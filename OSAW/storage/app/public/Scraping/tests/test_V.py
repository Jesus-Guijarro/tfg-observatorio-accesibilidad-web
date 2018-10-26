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

herramienta="vamola"

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
    driver.get('http://www.validatore.it/vamola_validator/checker/index.php')

    #Pausa explicita de 30 segundos
    #Se pausa hasta que se encuentra el elemento
    wait = WebDriverWait(driver, 30) 

    #Esperamos hasta que accedemos a la web de la herramienta
    #En caso negativo se cancela el análisis y se cierra el driver
    try:
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


    #Pausa de máximo 2 minuto
    wait = WebDriverWait(driver, 120)
    #Se espera hasta que se haya evaluado y ofrecido el resultado
    try:
        elem =wait.until(EC.presence_of_element_located((By.CSS_SELECTOR,"#tabresults > ul > li.ui-state-default.ui-corner-top.ui-tabs-selected.ui-state-active > a")))
    except:
        driver.quit()
        raise Exception('No se ha podido realizar la evaluación')


    num_problemas_conocidos=int(driver.find_element_by_css_selector("#AC_num_of_errors").text)
    #num_problemas_probables=driver.find_element_by_css_selector("#AC_num_of_likely")
    num_problemas_potenciales=int(driver.find_element_by_css_selector("#AC_num_of_potential").text)

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

    #Crear reporte y cálculo de los problemas por nivel de adecuación
    reporte = open(ruta_reporte, 'a')
    reporte.write(cabeceraReporte(pagina_url,fecha_test))

    datos=datosProblema("AC_errors",reporte,driver)
    
    if datos:
        num_problemas_conocidos_a = int(datos.count('(A)'))
        num_problemas_conocidos_aa = int(datos.count('(AA)'))
        num_problemas_conocidos_aaa = int(datos.count('(AAA)'))

    datos=datosProblema("AC_warnings",reporte,driver)
    if datos:
        num_problemas_potenciales_a = int(datos.count('(A)'))
        num_problemas_potenciales_aa = int(datos.count('(AA)'))
        num_problemas_potenciales_aaa = int(datos.count('(AAA)'))


    cursor = cursor.execute("insert into vamolas(pagina_id,num_problemas_conocidos, num_problemas_potenciales,num_problemas_conocidos_a,num_problemas_conocidos_aa,num_problemas_conocidos_aaa,num_problemas_potenciales_a,num_problemas_potenciales_aa,num_problemas_potenciales_aaa,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),num_problemas_conocidos, num_problemas_potenciales,num_problemas_conocidos_a,num_problemas_conocidos_aa,num_problemas_conocidos_aaa,num_problemas_potenciales_a,num_problemas_potenciales_aa,num_problemas_potenciales_aaa,ruta_BD,fecha_test,))
    desconexionBD(conexion,cursor)

except Exception as e:
    errorLog(directorio,1,getFecha(),herramienta,pagina_id, e)

driver.quit()
