from selenium import webdriver
from random import randint
from conexiones import *

import io
import sys
import requests
import mysql.connector

#Se pasa la URL del sitio por argumento
url= sys.argv[1]

#Headless mode
options = webdriver.ChromeOptions()

options.binary_location = '/usr/bin/google-chrome'
options.add_argument('headless')

driver = webdriver.Chrome(chrome_options=options)

driver.get(url)

enlaces = driver.find_elements_by_tag_name("a")

#Recuento
#print(len(enlaces))

#Lista para almacenar las páginas web
paginas = []

for enlace in enlaces:
    href = enlace.get_attribute("href")

    #Comprobamos primero que la referencia es un string
    if isinstance(href, str) == True:
        #Comprobamos la referencia tiene un formato: http://dominio/... y que no incluye el símbolo /# de menús y submenús de navegación
        if href.find(url)!=-1 and href.find(url,0,len(url))!=-1 and '#' not in href:
            paginas.append(href)

 
#Eliminamos duplicados y ordenamos la lista
paginas=list(sorted(set(paginas)))

for pagina in paginas:
    r = requests.get(pagina)
    if r.status_code == 404:
        paginas.remove(pagina)


#Lista para guardar las páginas a analizar del sitio
sitio = []

#Guardamos la dirección principal
sitio.append(url)

#Obtenemos 
for i in range(9):

    num=randint(0, len(paginas))
    #Añadimos el elemento
    sitio.append(paginas.__getitem__(num))
    #Para evitar que se repita el elemento lo eliminamos de la lista
    paginas.remove(paginas.__getitem__(num))

parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]



for pagina in sitio:
    cursor.execute("insert into paginas(idSitio,url) values(1,%s)",(pagina,))

#print(cursor.rowcount, "record inserted.")

desconexionBD(conexion,cursor)

driver.quit()

