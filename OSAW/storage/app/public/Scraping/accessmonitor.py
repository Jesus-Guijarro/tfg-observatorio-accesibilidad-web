#AccessMonitor

import sys, os

from conexiones import *
from miscelaneo import *
from googletrans import Translator


from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

#Argumentos
pagina_url=sys.argv[1]
pagina_id=sys.argv[2]

herramienta="accessmonitor"

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
        raise Exception('No se ha podido acceder a la herramienta')
        
    #Elemento input en el que se introduce la url de la pagina a evaluar
    enlace = driver.find_element_by_css_selector('#uri')
    enlace.clear()

    #Indicamos la url
    enlace.send_keys(pagina_url)
    #enlace.send_keys('https://www.elmundo.es/internacional.html')

    #Seleccionamos el análisis WCAG2.0
    botonWCAG2= driver.find_element_by_css_selector("#form1 > form > fieldset > div.center > input:nth-child(3)")
    botonWCAG2.click()

    #Se espera hasta que se haya evaluado y ofrecido el resultado
    try:
        elem = wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "#pagina > div.corpo > h2:nth-child(7)")))
    except:
        raise Exception('No se ha podido realizar la evaluación')
    

    puntuacion = driver.find_element_by_css_selector("#webaxscore > span")
    print(float(puntuacion.text))

    #Nivel A
    numErroresA= driver.find_element_by_css_selector("#block > table > tbody > tr.lev_A > td.txfail")
    print(int(numErroresA.text))

    numAvisosA= driver.find_element_by_css_selector("#block > table > tbody > tr.lev_A > td:nth-child(4)")
    print(int(numAvisosA.text))

    #Nivel AA
    numErroresAA= driver.find_element_by_css_selector("#block > table > tbody > tr.lev_AA > td.txfail")
    print(int(numErroresAA.text))

    numAvisosAA= driver.find_element_by_css_selector("#block > table > tbody > tr.lev_AA > td:nth-child(4)")
    print(int(numAvisosAA.text))

    #Nivel AAA
    numErroresAAA= driver.find_element_by_css_selector("#block > table > tbody > tr.lev_AAA > td.txfail")
    print(int(numErroresAAA.text))

    numAvisosAAA= driver.find_element_by_css_selector("#block > table > tbody > tr.lev_AAA > td:nth-child(4)")
    print(int(numAvisosAAA.text))

    datos=driver.find_elements_by_tag_name('h5')

    #Datos de las pruebas y traducción
    translator = Translator()

    for dato in datos:
        texto=dato.get_attribute('textContent')
        print(translator.translate(texto, dest='es', src='pt').text)

except Exception as e:
    print(repr(e))


driver.quit()





