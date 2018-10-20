import json
import io
import sys
import mysql.connector

from selenium import webdriver
from conexiones import *


#ARGUMENTOS
if len(sys.argv) < 2:
    print("Se analizan todos los sitios web")

else:
    print("Se analiza la URL " + sys.argv[1])


   
'''
#BASE DE DATOS
url="http://accesibilidadweb.dlsi.ua.es/"

parametros = conexionBD()

conexion= parametros[0]
cursor = parametros[1]

#cursor.execute("insert into sitios(idSitio,url) values(4,%s)",(url,))

lista = ["aaaaaaaaaaaaa","aaaaaaaaaaaaa","aaaaaaaaaaaaa","aaaaaaaaaaaaa"]

for i in lista:
    cursor.execute("insert into sitios(url) values(%s)",(i,))



cursor.execute("select idSitio from sitios where url = %s", ("http://www.elmundo.es",))

idSitio = cursor.fetchone()

print(idSitio.__getitem__(0))


desconexionBD(conexion,cursor)


#HEADLESS
options = webdriver.ChromeOptions()

options.binary_location = '/usr/bin/google-chrome'
options.add_argument('headless')

#Pruebas
#options.add_argument('window-size=1200x600')

driver = webdriver.Chrome(chrome_options=options)

#Accedemos a la web de la herramienta de evaluacion
driver.get('http://www.google.com')


#Guardamos la informacion obtenida en un archivo html resultado
with io.open('/home/jesus/google.html', 'w') as f:
    f.write(driver.page_source)


'''