import sys, requests, mysql.connector

from selenium import webdriver
from conexiones import *
from miscelaneo import *
from comprobador import *

parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

sitio_id=sys.argv[1]
num_paginas=int(sys.argv[2])

#Obtenemos la URL principal del sitio -> protocolo + dominio
cursor.execute("select dominio from sitios where id = %s", (sitio_id,))
r = cursor.fetchone()
dominio=r.__getitem__(0)

sitio_url=getURL(dominio)

def obtenerPaginas(sitio_id,sitio_url,num_paginas):

    #Modo Headless 
    opciones = webdriver.ChromeOptions()

    opciones.binary_location = '/usr/bin/google-chrome'
    opciones.add_argument('headless')

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
            #Comprobamos que la referencia tiene un formato correcto
            if comprobarReferencia(href, sitio_url):
                lista_paginas.append(href)
            
    
    #Contador
    i = 0

    #Eliminamos duplicados y ordenamos la lista
    lista_paginas=list(sorted(set(lista_paginas)))

    lista_final=[] #lista para guardar los enlaces que se van a almacenar en la BD
    
    

    #Segunda parte de comprobaciones para no duplicar paginas ya almacenadas en la base de datos y que sean accesibles
    for pagina in lista_paginas:
        if i >= num_paginas:
            break
        #Mirar posible mejora de rendimiento
        cursor.execute("select count(*) from paginas where URL=%s",(pagina,))
        resultado = cursor.fetchone()
        cantidad=resultado.__getitem__(0)
        #Si el resultado es 0 se comprueba y se añade en caso de ser valida
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
            if obtenerPaginas(sitio_id,url,i) == 0:
                return 0
        return i
    else:
        return i
        

obtenerPaginas(sitio_id,sitio_url,num_paginas)

