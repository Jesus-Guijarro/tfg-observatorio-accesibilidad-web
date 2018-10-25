import sys, requests, mysql.connector

from selenium import webdriver
from conexiones import *
from comprobador import comprobarAccesoyTipo

parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

sitio_id=sys.argv[1]
num_paginas=int(sys.argv[2])

#Obtenemos la URL principal del sitio -> protocolo + dominio
cursor.execute("select dominio from sitios where id = %s", (sitio_id,))
sitio = cursor.fetchone()
sitio_url=sitio.__getitem__(0)

def obtenerPaginas(sitio_id,sitio_url,num_paginas):

    #Modo Headless 
    opciones = webdriver.ChromeOptions()

    opciones.binary_location = '/usr/bin/google-chrome'
    #opciones.add_argument('headless')

    driver = webdriver.Chrome(chrome_options=opciones)

    driver.get(sitio_url)

    lista_enlaces = driver.find_elements_by_tag_name("a")

    #Lista para almacenar las urls de las páginas web
    lista_paginas = []

    #Comprobaciones para obtener enlaces correctos del sitio web
    for enlace in lista_enlaces:
        #Guardamos el valor del atributo "href" de cada enlace
        href = enlace.get_attribute("href")
        #Comprobamos primero que la referencia es un string
        if isinstance(href, str) == True:
            #Comprobamos la referencia tiene un formato: https://dominio... o http://dominio y que no incluye el símbolo /# de menús y submenús de navegación
            if href.find(sitio_url)!=-1 and href.find(sitio_url,0,len(sitio_url))!=-1 and '#' not in href:
                lista_paginas.append(href)
    
    #Guardamos la pagina principal
    lista_paginas.append(sitio_url)
    #Eliminamos duplicados y ordenamos la lista
    lista_paginas=list(sorted(set(lista_paginas)))
    
    lista_final=[] #lista para guardar los enlaces que se van a almacenar en la BD
    
    i = 1 #Contador

    #Segunda parte de comprobaciones para no duplicar paginas ya almacenadas en la base de datos y que sean accesibles
    for pagina in lista_paginas:
        if i > num_paginas:
            break
        cursor.execute("select count(*) from paginas where URL = %s", (pagina,))
        resultado = cursor.fetchone()
        cantidad=resultado.__getitem__(0)
        if cantidad==0:
            if comprobarAccesoyTipo(pagina): 
                lista_final.append(pagina)
                i = i+1
        
    for pagina in lista_final:
        cursor.execute("insert into paginas(sitio_id,URL) values(%s,%s)",(sitio_id,pagina,))
        
    conexion.commit()
    driver.quit()

    #Recursividad del crawler
    if i < num_paginas:
        for url in lista_final:
            if obtenerPaginas(sitio_id,url,i):
                return True
        return False
    else:
        return True
        

obtenerPaginas(sitio_id,sitio_url,num_paginas)

