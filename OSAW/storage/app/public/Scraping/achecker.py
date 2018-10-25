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


num_problemas_conocidos=driver.find_element_by_css_selector("#AC_num_of_errors")
print(int(num_problemas_conocidos.text))

num_problemas_probables=driver.find_element_by_css_selector("#AC_num_of_likely")
print(int(numProbables.text))

numPotenciales=driver.find_element_by_css_selector("#AC_num_of_potential")
print(int(numPotenciales.text))


#Generar reporte
exportar = driver.find_element_by_css_selector("#validate_file_button")
exportar.click()

element = wait.until(element_has_value((By.CSS_SELECTOR, "#validate_file_button"), "Get File"))



#Comprobar si hay errores de X tipo o no
'''

if EC.presence_of_element_located((By.CSS_SELECTOR, "#AC_congrats_msg_for_errors > img")) == False:
    erroresConocidos=driver.find_element_by_id("AC_errors")
if EC.presence_of_element_located((By.CSS_SELECTOR, "#AC_congrats_msg_for_likely > img")) == False:
    erroresPosibles=driver.find_element_by_id("AC_likely_problems")
if EC.presence_of_element_located((By.CSS_SELECTOR, "#AC_congrats_msg_for_potential > img")) == False:

'''

if EC.presence_of_element_located((By.ID, "AC_errors")):
    erroresConocidos=driver.find_element_by_id("AC_errors")
if EC.presence_of_element_located((By.ID, "AC_likely_problems")):
    erroresPosibles=driver.find_element_by_id("AC_likely_problems")
if EC.presence_of_element_located((By.ID, "AC_potential_problems")):
    erroresPotenciales=driver.find_element_by_id("AC_potential_problems")

datosConocidos=str(erroresConocidos.get_attribute('textContent'))
datosPosibles=str(erroresPosibles.get_attribute('textContent'))
datosPotenciales=str(erroresPotenciales.get_attribute('textContent'))

#No son simples saltos de linea , son lineas con espacios en blanco diferentes, tabulados, etc
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

with io.open('/home/jesus/pruebas/archivoACHECKER.text', 'w') as f:
    f.write(datosConocidos +'\n')
    #f.write(datosPosibles +"\n")
    f.write(datosPotenciales+"\n")


document.add_paragraph(datosConocidos)

document.save('dem2o.docx')

driver.close()
