#Crawler

import sys, requests, mysql.connector

from selenium import webdriver
from conexiones import *
from miscelaneo import *
from comprobador import *

sitio_id=sys.argv[1]
num_paginas=int(sys.argv[2])

#Conexion Base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

#Obtenemos la URL principal del sitio -> protocolo + dominio
cursor.execute("select dominio from sitios where id = %s", (sitio_id,))
d = cursor.fetchone()
dominio=d.__getitem__(0)
url=getURL(dominio) 


#Método para obtener las paginas solicitadas
def obtenerPaginas(sitio_id,url,num_paginas,profundidad):

    #Límite de profundidad del crawler a 2
    #Si se ha alcanzado el número de paginas no es necesario realizar el proceso
    if profundidad > 2 or num_paginas==0:
        return num_paginas

    #Conexion Base de datos
    parametros = conexionBD()
    conexion= parametros[0]
    cursor = parametros[1]

    #Modo Headless 
    driver = modoHeadless()
    #Accedemos al sitio
    driver.get(url)

    #Almacenamos todos los enlaces de la página actual
    lista_enlaces = driver.find_elements_by_tag_name("a")

    #Lista para almacenar las referencias (atributo "href") que hemos considerado válidas
    lista_paginas = []

    #Comprobaciones para obtener enlaces correctos del sitio web
    for enlace in lista_enlaces:
        #Guardamos el valor del atributo "href" de cada enlace
        try:
            href = enlace.get_attribute("href")
        except Exception as e:
            pass
        #Comprobamos primero que la referencia es un string
        if isinstance(href, str) == True:
            #Comprobamos que la referencia tiene un formato correcto
            if comprobarReferencia(href, url):
                lista_paginas.append(href)
            
    #Eliminamos duplicados y ordenamos la lista
    lista_paginas=list(sorted(set(lista_paginas)))

    lista_final=[] #lista para guardar los enlaces que pasan el segundo filtro y que se van a almacenar en la BD
    
    #Segunda parte de comprobaciones para no duplicar paginas ya almacenadas en la base de datos y que sean accesibles
    for pagina in lista_paginas:
        if num_paginas == 0:
            break
        cursor.execute("select count(*) from paginas where URL=%s",(pagina,))
        resultado = cursor.fetchone()
        cantidad=resultado.__getitem__(0)
        #Si el resultado es 0 se comprueba y se añade en caso de que se pueda acceder a ella
        if cantidad==0:
            if comprobarAccesoyTipo(pagina): 
                #Se guardan las páginas que han pasado los filtros
                cursor.execute("insert into paginas(sitio_id,URL) values(%s,%s)",(sitio_id,pagina,))
                lista_final.append(pagina)
                num_paginas = num_paginas - 1 #Se reduce el número de páginas a buscar
    
    #Realizamos el proceso de desconexión de la base de datos y cerramos el driver del modo headless
    desconexionBD(conexion,cursor)
    driver.quit()


    #Llamada recursiva
    for pagina in lista_final:
        if num_paginas == 0:
            return 0
        else:
            num_paginas= obtenerPaginas(sitio_id,pagina,num_paginas,profundidad+1)

    return num_paginas
        
obtenerPaginas(sitio_id,url,num_paginas,0)

