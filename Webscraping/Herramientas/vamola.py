#Vamola
import sys, os

directorio_import = os.path.dirname(os.path.abspath(__file__))
directorio_import = directorio_import.replace('/Herramientas','')
sys.path.append(directorio_import)

from database import conexionBD,desconexionBD
from herramienta import getDirectorioOSAW,getFecha, driverHeadlessBrowser, getRutaReporte, getCabeceraReporte, getDatosProblemas, getNumeroProblemas, errorLog

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC


#Método para ejecutar el proceso de evaluación
def ejecutarVamola(pagina_id,pagina_url,herramienta,conexion,cursor):

    directorio = getDirectorioOSAW()
    fecha_test=getFecha()

    try:
        #Activamos el modo headless
        driver=driverHeadlessBrowser()

        #Pausa explicita de 10 segundos
        #Se pausa hasta que se encuentra el elemento
        wait = WebDriverWait(driver, 10) 

        #Esperamos hasta que accedemos a la web de la herramienta
        #En caso negativo se cancela el análisis y se cierra el driver
        try:
            #Accedemos a la web de la herramienta de evaluacion
            driver.get('http://www.validatore.it/vamola_validator/checker/index.php')
            elem =wait.until(EC.title_is(("Vamolà, validatore e monitor per l'accessibilità : Web Accessibility Checker")))
        except:
            driver.quit()
            raise Exception('No se ha podido acceder a la herramienta')

        #Introducir URL
        enlace = driver.find_element_by_css_selector('#checkuri')
        enlace.clear()
        enlace.send_keys(pagina_url)

        #Se abren las opciones de evaluación
        opcionWCAG2 = driver.find_element_by_css_selector('#radio_gid_9')
        opcionWCAG2.click()

        #Se selecciona el botón para evaluar
        check = driver.find_element_by_css_selector('#validate_uri')

        check.click()

        #Pausa de máximo 90 segundos
        wait = WebDriverWait(driver, 90)
        #Se espera hasta que se haya evaluado y ofrecido el resultado
        try:
            elem =wait.until(EC.presence_of_element_located((By.CSS_SELECTOR,"#tabresults > ul > li.ui-state-default.ui-corner-top.ui-tabs-selected.ui-state-active > a")))
        except:
            driver.quit()
            raise Exception('No se ha podido realizar la evaluación')

        #Número de problemas conocidos y de problemas potenciales
        num_problemas_conocidos=int(driver.find_element_by_css_selector("#AC_num_of_errors").text)
        num_problemas_potenciales=int(driver.find_element_by_css_selector("#AC_num_of_potential").text)


        #Rutas para guardar el archivo y el acceso desde la BD
        ruta_reporte=getRutaReporte(directorio,herramienta,pagina_id,fecha_test)
        ruta_BD=getRutaReporte("",herramienta,pagina_id,fecha_test)

        #Crear reporte y cálculo de los problemas por nivel de adecuación
        reporte = open(ruta_reporte, 'a')
        reporte.write(getCabeceraReporte(pagina_url,fecha_test))

        #Problemas conocidos
        datos=getDatosProblemas("AC_errors",reporte,driver)
        num_problemas_conocidos_a = getNumeroProblemas(datos,'(A)')
        num_problemas_conocidos_aa = getNumeroProblemas(datos,'(AA)')
        num_problemas_conocidos_aaa = getNumeroProblemas(datos,'(AAA)')

        #Problemas potenciales
        datos=getDatosProblemas("AC_warnings",reporte,driver)
        num_problemas_potenciales_a = getNumeroProblemas(datos,'(A)')
        num_problemas_potenciales_aa = getNumeroProblemas(datos,'(AA)')
        num_problemas_potenciales_aaa = getNumeroProblemas(datos,'(AAA)')

        reporte.close()

        #Se guarda en la BD
        cursor = cursor.execute("insert into vamolas(pagina_id,num_problemas_conocidos, num_problemas_potenciales,num_problemas_conocidos_a,num_problemas_conocidos_aa,num_problemas_conocidos_aaa,num_problemas_potenciales_a,num_problemas_potenciales_aa,num_problemas_potenciales_aaa,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),num_problemas_conocidos, num_problemas_potenciales,num_problemas_conocidos_a,num_problemas_conocidos_aa,num_problemas_conocidos_aaa,num_problemas_potenciales_a,num_problemas_potenciales_aa,num_problemas_potenciales_aaa,ruta_BD,fecha_test,))
        
        desconexionBD(conexion)

    except Exception as e:
        errorLog(directorio,fecha_test,herramienta,pagina_id,e)

    driver.quit()

#Argumentos
pagina_id=sys.argv[1]
pagina_url=sys.argv[2]

herramienta="vamola"

#Conexion base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

ejecutarVamola(pagina_id,pagina_url,herramienta,conexion,cursor)
desconexionBD(conexion)