#Crawler

import sys, requests, mysql.connector

from selenium import webdriver
from conexiones import *
from miscelaneo import *
from comprobador import *

sitio_id=sys.argv[1]
num_paginas=int(sys.argv[2])

parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]


#Obtenemos la URL principal del sitio -> protocolo + dominio
cursor.execute("select dominio from sitios where id = %s", (sitio_id,))
r = cursor.fetchone()
dominio=r.__getitem__(0)
sitio_url=getURL(dominio) 

#Método para obtener las paginas solicitadas
def obtenerPaginas(sitio_id,sitio_url,num_paginas):
    #Modo Headless 
    driver = modoHeadless()
    #Accedemos al sitio
    driver.get(sitio_url)

    #Almacenamos todos los enlaces de la página actual
    lista_enlaces = driver.find_elements_by_tag_name("a")

    #Lista para almacenar las referencias (atributo "href") que hemos considerado válidas
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
            
    #Eliminamos duplicados y ordenamos la lista
    lista_paginas=list(sorted(set(lista_paginas)))

    lista_final=[] #lista para guardar los enlaces que pasan el segundo filtro y que se van a almacenar en la BD
    
    #Contador para saber cuantas paginas llevamos guardadas
    guardadas = 0
    #Segunda parte de comprobaciones para no duplicar paginas ya almacenadas en la base de datos y que sean accesibles
    for pagina in lista_paginas:
        #Si se alcanza el número de paginas solicitadas se finaliza la búsqueda
        if guardadas >= num_paginas:
            return True
        #Mirar posible mejora de rendimiento ¿hash URL?
        cursor.execute("select count(*) from paginas where URL=%s",(pagina,))
        resultado = cursor.fetchone()
        cantidad=resultado.__getitem__(0)
        #Si el resultado es 0 se comprueba y se añade en caso de que se pueda acceder a ella
        if cantidad==0:
            if comprobarAccesoyTipo(pagina): 
                    lista_final.append(pagina)
                    guardadas += 1
        
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

