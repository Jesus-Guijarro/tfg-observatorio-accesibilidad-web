#PowerMapper

from selenium import webdriver

from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

import io

#Se virtualiza una ventana de navegacion de Chrome

options = webdriver.ChromeOptions()

options.binary_location = '/usr/bin/google-chrome'
#options.add_argument('headless')

#Pruebas
options.add_argument('window-size=1200x600')

driver = webdriver.Chrome(chrome_options=options)

#Accedemos a la web de la herramienta de evaluacion
driver.get('http://examinator.ws/')
#driver.get("file:///home/jesus/Desktop/examinator.html")


wait = WebDriverWait(driver, 200)

elem =wait.until(EC.title_is(("examinator")))

######HTTP######
'''
#Introducir URL
enlace = driver.find_element_by_css_selector('#uri')
enlace.clear()
enlace.send_keys('http://www.elmundo.es/internacional.html/')

#Evaluar
boton= driver.find_element_by_css_selector("#form1 > form > p:nth-child(2) > input.submit")
boton.click()

'''
#######HTTPS######

opcion= driver.find_element_by_css_selector("#tabs > li:nth-child(2) > a")
opcion.click()

elem = wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "#up_file")))

#Para poder introducir un archivo
driver.file_detector

archivo = driver.find_element_by_css_selector('#up_file')
archivo.click()
archivo.send_keys("/home/jesus/Desktop/test.html")


#Evaluar
boton= driver.find_element_by_css_selector("#form2 > form > p:nth-child(2) > input.submit")
boton.click()


################################################
elem = wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "#hscore")))


puntuacion= driver.find_element_by_css_selector("#hscore")
print(float(puntuacion.text))

resultados= driver.find_element_by_css_selector("#results")
print(resultados.text)


excelente= driver.find_element_by_css_selector("#tabs > li:nth-child(1) > a")
print(excelente.text)

regular= driver.find_element_by_css_selector("#tabs > li:nth-child(2) > a")
print(regular.text)

mal= driver.find_element_by_css_selector("#tabs > li:nth-child(3) > a")
print(mal.text)

muyMal= driver.find_element_by_css_selector("#tabs > li:nth-child(4) > a")
print(muyMal.text)


datos=driver.find_elements_by_class_name("left")

with io.open('/home/jesus/archivo.txt', 'w') as f:
    for dato in datos:
        f.write(dato.get_attribute('textContent') +"\n")


driver.close()