#AChecker
import sys, os

directorio_import = os.path.dirname(os.path.abspath(__file__))
directorio_import = directorio_import.replace('/Herramientas','')
sys.path.append(directorio_import)

from database import conexion,desconexion
from herramienta import getDirectorioOSAW,getFecha, driverHeadlessBrowser, getRutaReporte, getCabeceraReporte,getDatosProblemas,getNumeroProblemas, errorLog

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

from timer import calcularTiemposAcceso
from time import time

#Método para ejecutar el proceso de evaluación
def ejecutarAchecker(pagina_id,pagina_url,herramienta,conexion,cursor):

    directorio = getDirectorioOSAW()
    fecha_test=getFecha()

    try:
        #Activamos el modo headless
        driver=driverHeadlessBrowser()

        #Accedemos a la web de la herramienta de evaluacion
        driver.get('https://achecker.ca/checker/index.php')

        #Pausa explicita de 30 segundos
        #Se pausa hasta que se encuentra el elemento
        wait = WebDriverWait(driver, 30) 

        #Esperamos hasta que accedemos a la web de la herramienta
        #En caso negativo se cancela el análisis y se cierra el driver
        try:
            t1=time()
            elem =wait.until(EC.title_is(("IDI Web Accessibility Checker : Web Accessibility Checker")))
            tiempo=time()-t1
            calcularTiemposAcceso("achecker",tiempo,"ACCESO HERRAMIENTA")
        except:
            driver.quit()
            raise Exception('No se ha podido acceder a la herramienta')

        #Introducir URL
        enlace = driver.find_element_by_css_selector('#checkuri')
        enlace.clear()
        enlace.send_keys(pagina_url)

        #Se abren las opciones de evaluación
        opciones=  driver.find_element_by_css_selector("#center-content > table > tbody > tr > td > div > form > div > fieldset > div:nth-child(6) > h2 > a")
        opciones.click()

        #Se selecciona opción WCAG 2.0
        #Es necesario esperar ya que las opciones se generan con javascript
        elem = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR,"#radio_gid_9"))) 
        opcionWCAG2=  driver.find_element_by_css_selector("#radio_gid_9")
        opcionWCAG2.click()

        #Se selecciona el botón para evaluar
        boton= driver.find_element_by_css_selector("#validate_uri")
        boton.click()

        #Pausa de máximo 2 minutos
        wait = WebDriverWait(driver, 120)
        #Se espera hasta que se haya evaluado y ofrecido el resultado
        try:
            t1=time()
            elem = wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "#report_file > div > label:nth-child(1)")))
            tiempo=time()-t1
            calcularTiemposAcceso("achecker",tiempo,"EVALUACIÓN")
        except:
            driver.quit()
            raise Exception('No se ha podido realizar la evaluación')

        num_problemas_conocidos=int(driver.find_element_by_css_selector("#AC_num_of_errors").text)
        #num_problemas_probables=driver.find_element_by_css_selector("#AC_num_of_likely")
        num_problemas_potenciales=int(driver.find_element_by_css_selector("#AC_num_of_potential").text)

        #Rutas para guardar el archivo y el acceso desde la BD
        ruta_reporte=getRutaReporte(directorio,herramienta,pagina_id,fecha_test)
        ruta_BD=getRutaReporte("",herramienta,pagina_id,fecha_test)

        #Crear reporte y cálculo de los problemas por nivel de adecuación
        reporte = open(ruta_reporte, 'a')
        reporte.write(getCabeceraReporte(pagina_url,fecha_test))

        datos=getDatosProblemas("AC_errors",reporte,driver)
        num_problemas_conocidos_a = getNumeroProblemas(datos,'(A)')
        num_problemas_conocidos_aa = getNumeroProblemas(datos,'(AA)')
        num_problemas_conocidos_aaa = getNumeroProblemas(datos,'(AAA)')

        datos=getDatosProblemas("AC_potential_problems",reporte,driver)
        num_problemas_potenciales_a = getNumeroProblemas(datos,'(A)')
        num_problemas_potenciales_aa = getNumeroProblemas(datos,'(AA)')
        num_problemas_potenciales_aaa = getNumeroProblemas(datos,'(AAA)')

        reporte.close()

        cursor = cursor.execute("insert into acheckers(pagina_id,num_problemas_conocidos, num_problemas_potenciales,num_problemas_conocidos_a,num_problemas_conocidos_aa,num_problemas_conocidos_aaa,num_problemas_potenciales_a,num_problemas_potenciales_aa,num_problemas_potenciales_aaa,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),num_problemas_conocidos, num_problemas_potenciales,num_problemas_conocidos_a,num_problemas_conocidos_aa,num_problemas_conocidos_aaa,num_problemas_potenciales_a,num_problemas_potenciales_aa,num_problemas_potenciales_aaa,ruta_BD,fecha_test,))
        
        desconexion(conexion)

    except Exception as e:
        errorLog(directorio,1,fecha_test,herramienta,pagina_id,e)

    driver.quit()


#Argumentos
pagina_id=sys.argv[1]
pagina_url=sys.argv[2]

herramienta="achecker"

#Conexion base de datos
parametros = conexion()
conexion= parametros[0]
cursor = parametros[1]

ejecutarAchecker(pagina_id,pagina_url,herramienta,conexion,cursor)
desconexion(conexion)