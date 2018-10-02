from selenium import webdriver

import io

#Se virtualiza una ventana de navegacion de Chrome

options = webdriver.ChromeOptions()

options.binary_location = '/usr/bin/google-chrome'
options.add_argument('headless')

#Pruebas
#options.add_argument('window-size=1200x600')

driver = webdriver.Chrome(chrome_options=options)

#Accedemos a la web de la herramienta de evaluacion
driver.get('http://www.google.com')


driver.implicitly_wait(1)


#URL a introducir
URL = driver.find_element_by_css_selector('#lst-ib')
URL.send_keys('Ejemplo')

driver.implicitly_wait(5)
#Boton de submit
aceptar = driver.find_element_by_name('btnK')
aceptar.submit()

#Guardamos la informacion obtenida en un archivo html resultado
with io.open('/home/jesus/google.html', 'w') as f:
    f.write(driver.page_source)
