#AccessMonitor
import io
from conexiones import *

from selenium import webdriver

from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

from googletrans import Translator


#Se virtualiza una ventana de navegacion de Chrome

options = webdriver.ChromeOptions()

options.binary_location = '/usr/bin/google-chrome'
options.add_argument('headless')

#Pruebas
#options.add_argument('window-size=1200x600')

driver = webdriver.Chrome(chrome_options=options)
'''
#Accedemos a la web de la herramienta de evaluacion
driver.get('http://www.acessibilidade.gov.pt/accessmonitor/')


wait = WebDriverWait(driver, 20)
elem =wait.until(EC.title_is(("AccessMonitor")))
    
enlace = driver.find_element_by_css_selector('#uri')

enlace.clear()
#enlace.send_keys('http://accesibilidadweb.dlsi.ua.es/')
enlace.send_keys('https://www.elmundo.es/internacional.html')

botonWCAG2= driver.find_element_by_css_selector("#form1 > form > fieldset > div.center > input:nth-child(3)")
botonWCAG2.click()

elem = wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "#pagina > div.corpo > h2:nth-child(7)")))

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

driver.quit()
'''




