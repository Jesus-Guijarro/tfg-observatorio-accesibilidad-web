#AccessMonitor

import sys

from conexiones import *
from miscelaneo import getDirectorio,getFecha, modoHeadless, getRutaReporte, cabeceraReporte, errorLog
from googletrans import Translator


from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

#Argumentos
pagina_url=sys.argv[1]
pagina_id=sys.argv[2]

herramienta="accessmonitor"

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
    driver.get('http://www.acessibilidade.gov.pt/accessmonitor/')

    #Pausa explicita de 30 segundos
    #Se pausa hasta que se encuentra el elemento
    wait = WebDriverWait(driver, 30) 

    #Esperamos hasta que accedemos a la web de la herramienta
    #En caso negativo se cancela el análisis y se cierra el driver
    try:
        elem =wait.until(EC.title_is(("AccessMonitor")))
    except:
        driver.quit()
        raise Exception('No se ha podido acceder a la herramienta')
        
    #Elemento input en el que se introduce la url de la pagina a evaluar
    enlace = driver.find_element_by_css_selector('#uri')
    enlace.clear()

    #Indicamos la url
    enlace.send_keys(pagina_url)

    #Seleccionamos el análisis WCAG2.0
    botonWCAG2= driver.find_element_by_css_selector("#form1 > form > fieldset > div.center > input:nth-child(3)")
    botonWCAG2.click()

    #Pausa de máximo 2 minutos
    wait = WebDriverWait(driver, 120)
    #Se espera hasta que se haya evaluado y ofrecido el resultado
    try:
        elem = wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "#pagina > div.corpo > h2:nth-child(7)")))
    except:
        driver.quit()
        raise Exception('No se ha podido realizar la evaluación')
    
    #Puntuación
    puntuacion = float(driver.find_element_by_css_selector("#webaxscore > span").text)

    #En ocasiones los elementos  de algún nivel de conformidad no se muestran 
    #Función para obtener los errores como las advertencias
    def getValor(css_selector,driver):
        try:
            valor=int(driver.find_element_by_css_selector(css_selector).text)
            return valor

        except Exception as e:
            return 0

    #Nivel A
    num_problemas_a= getValor("#block > table > tbody > tr.lev_A > td.txfail",driver)
    num_advertencias_a= getValor("#block > table > tbody > tr.lev_A > td:nth-child(4)",driver)

    #Nivel AA
    num_problemas_aa= getValor("#block > table > tbody > tr.lev_AA > td.txfail",driver)
    num_advertencias_aa= getValor("#block > table > tbody > tr.lev_AA > td:nth-child(4)",driver)
    #Nivel AAA
    num_problemas_aaa= getValor("#block > table > tbody > tr.lev_AAA > td.txfail",driver)
    num_advertencias_aaa= getValor("#block > table > tbody > tr.lev_AAA > td:nth-child(4)",driver)
   
    #Obtenemos los datos generales del reporte
    datos=driver.find_elements_by_tag_name('h5')

    #Rutas para guardar el archivo y el acceso desde la BD
    ruta_reporte=getRutaReporte(directorio,herramienta,pagina_id,fecha_test)
    ruta_BD=getRutaReporte("",herramienta,pagina_id,fecha_test)

    #Crear reporte
    reporte = open(ruta_reporte, 'a')
    reporte.write(cabeceraReporte(pagina_url,fecha_test))
    
    #Usamos un traductor debido a que la información del reporte está en portugués
    translator = Translator()

    for dato in datos:
        texto=dato.get_attribute('textContent')
        traduccion=str(translator.translate(texto, dest='es', src='pt').text + "\n")
        reporte.write(traduccion)

    #Guardamos los datos en la BD
    
    cursor = cursor.execute("insert into accessmonitors(pagina_id,puntuacion,num_problemas_a, num_problemas_aa,num_problemas_aaa,num_advertencias_a,num_advertencias_aa,num_advertencias_aaa,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),puntuacion,num_problemas_a, num_problemas_aa,num_problemas_aaa,num_advertencias_a,num_advertencias_aa,num_advertencias_aaa,ruta_BD,fecha_test,))
    reporte.close()
    desconexionBD(conexion,cursor)
    
except Exception as e:
    errorLog(directorio,1,getFecha(),herramienta,pagina_id,e)


driver.quit()





