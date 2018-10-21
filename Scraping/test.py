import io
from selenium import webdriver

options = webdriver.ChromeOptions()

options.binary_location = '/usr/bin/google-chrome'
options.add_argument('headless')

#Pruebas
#options.add_argument('window-size=1200x600')

driver = webdriver.Chrome(chrome_options=options)

#Accedemos a la web de la herramienta de evaluacion
driver.get('https://sede.mjusticia.gob.es/cs/Satellite/Sede/es/inicio')


#Guardamos la informacion obtenida en un archivo html resultado
with io.open('file1.html', 'w') as f:
    f.write(driver.page_source)