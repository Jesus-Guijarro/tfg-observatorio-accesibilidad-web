#Vamolà
from selenium import webdriver

from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

import io

#Se virtualiza una ventana de navegacion de Chrome

options = webdriver.ChromeOptions()

options.binary_location = '/usr/bin/google-chrome'
options.add_argument('headless')

#Pruebas
options.add_argument('window-size=1200x600')

driver = webdriver.Chrome(chrome_options=options)

#Accedemos a la web de la herramienta de evaluacion
#driver.get('http://www.validatore.it/vamola_validator/checker/index.php')
driver.get("file:///home/jesus/Desktop/testVAMOLA1.html")


wait = WebDriverWait(driver, 200)
'''
elem =wait.until(EC.title_is(("Vamolà, validatore e monitor per l'accessibilità : Web Accessibility Checker")))

#Introducir URL
enlace = driver.find_element_by_css_selector('#checkuri')
enlace.clear()
enlace.send_keys('http://www.elmundo.es/deportes.html')

#Seleccionar opcion
opcionWCAG2 = driver.find_element_by_css_selector('#radio_gid_9')
opcionWCAG2.click()

#Evaluar
check = driver.find_element_by_css_selector('#validate_uri')
check.click()


elem =wait.until(EC.presence_of_element_located((By.CSS_SELECTOR,"#tabresults > ul > li.ui-state-default.ui-corner-top.ui-tabs-selected.ui-state-active > a")))
'''

numErroresConocidos=driver.find_element_by_css_selector('#AC_num_of_errors')
print(int(numErroresConocidos.text))

numErroresPotenciales=driver.find_element_by_css_selector('#AC_num_of_potential')
print(int(numErroresPotenciales.text))


erroresConocidos=driver.find_element_by_id("AC_errors")
erroresPotenciales=driver.find_element_by_id("AC_warnings")

datosConocidos=str(erroresConocidos.get_attribute('textContent'))
datosPotenciales=str(erroresPotenciales.get_attribute('textContent'))

datosConocidos=datosConocidos.replace('  ','')
datosConocidos=datosConocidos.replace('\n','')
datosConocidos=datosConocidos.replace('        ','\n\n')
datosConocidos=datosConocidos.replace('Success Criteria','\n\nSuccess Criteria')
datosConocidos=datosConocidos.replace('Check','\n\n\tCheck')
datosConocidos=datosConocidos.replace('Repair','\n\n\tRepair')
datosConocidos=datosConocidos.replace('Line','\n\n\t\tLine')
datosConocidos=datosConocidos.replace('\t\t\t','')	

datosPotenciales=datosPotenciales.replace('  ','')
datosPotenciales=datosPotenciales.replace('\n','')
datosPotenciales=datosPotenciales.replace('        ','\n\n')
datosPotenciales=datosPotenciales.replace('Success Criteria','\n\nSuccess Criteria')
datosPotenciales=datosPotenciales.replace('Check','\n\n\tCheck')
datosPotenciales=datosPotenciales.replace('Repair','\n\n\tRepair')
datosPotenciales=datosPotenciales.replace('Line','\n\n\t\tLine')
datosPotenciales=datosPotenciales.replace('\t\t\t','')
	

with io.open('/home/jesus/pruebas/archivoVAMOLA.txt', 'w') as f:
    f.write(datosConocidos +"\n")
    f.write(datosPotenciales)

driver.close()
