#AChecker
import sys

from conexiones import *
from miscelaneo import *

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

#Argumentos
pagina_url=sys.argv[1]
pagina_id=sys.argv[2]

herramienta="achecker"

#Conexion base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

#Ruta del directorio actual
directorio = getDirectorio()

fecha_test=getFecha()


try:
    #Activamos el modo headless
    driver=modoHeadless()

    #Accedemos a la web de la herramienta de evaluacion
    driver.get('https://achecker.ca/checker/index.php')

    #Pausa explicita de 30 segundos
    #Se pausa hasta que se encuentra el elemento
    wait = WebDriverWait(driver, 30) 

    #Esperamos hasta que accedemos a la web de la herramienta
    #En caso negativo se cancela el análisis y se cierra el driver
    try:
        elem =wait.until(EC.title_is(("IDI Web Accessibility Checker : Web Accessibility Checker")))
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


    #Pausa de máximo 2 minuto
    wait = WebDriverWait(driver, 120)
    #Se espera hasta que se haya evaluado y ofrecido el resultado
    try:
        elem = wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "#report_file > div > label:nth-child(1)")))
    except:
        driver.quit()
        raise Exception('No se ha podido realizar la evaluación')


    num_problemas_conocidos=int(driver.find_element_by_css_selector("#AC_num_of_errors").text)
    print(num_problemas_conocidos)

    #num_problemas_probables=driver.find_element_by_css_selector("#AC_num_of_likely")
    #print(int(num_probables.text))

    num_problemas_potenciales=int(driver.find_element_by_css_selector("#AC_num_of_potential").text)
    print(num_problemas_potenciales)

    #Inicializamos las variables para hacer el recuento de problemas segun nivel
    num_problemas_conocidos_a = 0
    num_problemas_conocidos_aa = 0
    num_problemas_conocidos_aaa = 0
    num_problemas_potenciales_a = 0
    num_problemas_potenciales_aa = 0
    num_problemas_potenciales_aaa = 0

    #Rutas para guardar el archivo y el acceso desde la BD
    ruta_reporte=getRutaReporte(directorio,herramienta,pagina_id,fecha_test)
    ruta_BD=getRutaReporte("",herramienta,pagina_id,fecha_test)

    #Crear reporte
    reporte = open(ruta_reporte, 'a')
    reporte.write('Reporte de la página web: ' + pagina_url+ '\t\t'+"Fecha: "+ fecha_test+'\n')

    #Datos problemas y calculo de número de problemas según nivel
    def datoProblema(tipo_problema):
        try:
            problemas=driver.find_element_by_id(tipo_problema)

            datos=str(problemas.get_attribute('textContent'))
            datos=transformarDatos(datos)

            if tipo_problema == "AC_errors":
                reporte.write("PROBLEMAS CONOCIDOS\n")

                num_problemas_conocidos_a = int(datos.count("(A)"))
                num_problemas_conocidos_aa = int(datos.count("(AA)"))
                num_problemas_conocidos_aaa = int(datos.count("(AAA)"))

                reporte.write(datos + "\n\n ------------------------------------------------------ \n\n")
            else:
                reporte.write("PROBLEMAS POTENCIALES\n")

                num_problemas_potenciales_a = int(datos.count("(A)"))
                num_problemas_potenciales_aa = int(datos.count("(AA)"))
                num_problemas_potenciales_aaa = int(datos.count("(AAA)"))

                reporte.write(datos + "\n")

        except Exception as e:
            pass

    #Obtenemos los datos para errores conocidos y potenciales
    datoProblema("AC_errors")
    datoProblema("AC_potential_problems")

    cursor = cursor.execute("insert into achecker(pagina_id,puntuacion,num_problemas, num_aciertos,num_problemas_a,num_problemas_aa,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),puntuacion,num_problemas, num_aciertos,num_problemas_a,num_problemas_aa,ruta_BD,fecha_test,))
    desconexionBD(conexion,cursor)

except Exception as e:
    errorLog(directorio,1,getFecha(),herramienta,pagina_id)


driver.quit()
