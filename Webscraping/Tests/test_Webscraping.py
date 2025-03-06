
from selenium import webdriver

opciones = webdriver.ChromeOptions()

opciones.binary_location = '/usr/bin/google-chrome'


driver = webdriver.Chrome(chrome_options=opciones)

driver.get('http://www.gva.es/es/inicio/administraciones/adm_tramites_y_servicios')