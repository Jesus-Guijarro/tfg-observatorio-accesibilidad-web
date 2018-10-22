#EIII Page Checker

from selenium import webdriver

from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC


#translator.translate(texto, dest='es').text

#Se virtualiza una ventana de navegacion de Chrome

options = webdriver.ChromeOptions()

options.binary_location = '/usr/bin/google-chrome'
options.add_argument('headless')

#Pruebas
options.add_argument('window-size=1200x600')

driver = webdriver.Chrome(chrome_options=options)

#Accedemos a la web de la herramienta de evaluacion
driver.get('http://checkers.eiii.eu/en/pagecheck/')
#driver.get("file:///home/jesus/Desktop/test.html")


wait = WebDriverWait(driver, 200)

elem =wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "#logo > h1")))

#Comprobamos que aparece la advertencia inicial
if EC.element_to_be_clickable((By.CSS_SELECTOR, "#premission_question > p > button")):
    accept =  driver.find_element_by_css_selector("#premission_question > p > button")
    accept.click()



URL =  driver.find_element_by_css_selector("#id_url")
URL.send_keys('http://www.elmundo.es/internacional.html')

check =  driver.find_element_by_css_selector('#page_checker > div > input[type="submit"]')
check.click()

elem =wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "#resultSummary > form > ul > li:nth-child(1) > label > strong")))

numTests =  driver.find_element_by_css_selector('#ul-appliedtests > li:nth-child(1)')
print(int(numTests.text.replace('Total: ','')))

numErrores =  driver.find_element_by_css_selector('#ul-appliedtests > li:nth-child(2) > strong > span')
print(int(numErrores.text.replace('Fail: ','')))

puntuacion = driver.find_element_by_css_selector('#resultSummary > form > ul > li:nth-child(4) > div > span > span')
print(float(puntuacion.text))

#Datos errores

textos=driver.find_element_by_id("icon_alt-on-img_rstFail")
print(int(textos.text))


'''
icon_alt-on-img_rstFail
icon_use-color_rstFail
icon_pointing-device-events_rstFail
icon_title-not-descriptive_rstFail
icon_links-webpages_rstFail
icon_descriptive-headings_rstFail
icon_language-determine_rstFail
icon_language-attributes-page_rstFail
icon_forms-without-buttons_rstFail
icon_submit-buttons_rstFail
icon_h71-sturcture_rstFail
icon_referencing-element_rstFail
icon_id-unique-value_rstFail
icon_title-frame-iframe_rstFail
icon_null-alt-image_rstFail
icon_form-controls-links_rstFail
icon_script-ui-control_rstFail

Use alt en elementos img [1.1.1]
Uso del color [1.4.1]
Uso de controladores de eventos específicos del dispositivo señalador únicamente [2.1.1]
Proporcione títulos descriptivos para páginas web [2.4.2]
Proporcionar enlaces para navegar a páginas web relacionadas [2.4.5]
Proporcione encabezados descriptivos [2.4.6]
Lenguaje principal de la página [3.1.1]
Idiomas dentro del cuerpo [3.1.2]
Enviar formularios sin enviar botones [3.2.2]
Proporcione un botón de enviar para iniciar un cambio de contexto [3.2.2]
Etiquetar grupos de elementos de formulario [3.3.2]
Elementos de referencia [4.1.1]
Definir identificadores para elementos [4.1.1]
Usa el título para los elementos frame e iframe [4.1.2]
Nombre accesible para imágenes con enlace [4.1.2]
Utilice los controles y enlaces de formulario HTML [4.1.2]
Proporcione el nombre del rol para div / span con el controlador de eventos [4.1.2]
'''

driver.close()