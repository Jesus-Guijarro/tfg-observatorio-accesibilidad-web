#Crawler

import sys, requests, mysql.connector

from selenium import webdriver
from database import conexionDB,desconexionDB
from herramienta import driverHeadlessBrowser
from comprobaciones import comprobarAccesoPagina


#Función para comprobar que la referencia tiene un formato: https://dominio... o http://dominio y que no incluye el símbolo /# de menús y submenús de navegación
def comprobarReferencia(href, sitio_url):
    if href.find(sitio_url)!=-1 and href.find(sitio_url,0,len(sitio_url))!=-1 and '#' not in href: #El '#' es por la herramienta observatorio.py
        return True
    return False


#Obtenemos la URL principal del sitio -> protocolo + dominio
def getURL(sitio_id,cursor):

    cursor.execute("select dominio from sitios where id = %s", (sitio_id,))
    d = cursor.fetchone()
    dominio=d.__getitem__(0)

    #Comprobamos si el protocolo es https
    cabecera="http://"
    request = requests.get(cabecera+dominio)
    url = request.url
    
    if "https://" in url:
        cabecera = "https://"

    url = cabecera + dominio

    return url

#Método para obtener las paginas solicitadas
def getPaginas(sitio_id,url,num_paginas,profundidad,conexion,cursor):

    #Límite de profundidad del crawler a 2
    #Si se ha alcanzado el número de paginas no es necesario realizar el proceso
    if profundidad > 2 or num_paginas==0:
        return num_paginas

    #Modo Headless 
    driver = driverHeadlessBrowser()
    #Accedemos al sitio
    driver.get(url)

    #Almacenamos todos los enlaces de la página actual
    enlaces = driver.find_elements_by_tag_name("a")

    #Lista para almacenar las referencias (atributo "href") que hemos considerado válidas
    paginas = []

    #checker para obtener enlaces correctos del sitio web
    for enlace in enlaces:
        #Guardamos el valor del atributo "href" de cada enlace
        try:
            href = enlace.get_attribute("href")
        except Exception as e:
            pass
        #Comprobamos primero que la referencia es un string
        if isinstance(href, str) == True:
            #Comprobamos que la referencia tiene un formato correcto
            if comprobarReferencia(href, url):
                paginas.append(href)
            
    #Eliminamos duplicados y ordenamos la lista
    paginas=list(sorted(set(paginas)))

    paginas_validas=[] #lista para guardar los enlaces que pasan el segundo filtro y que se van a almacenar en la BD
    
    #Segunda parte de checker para no duplicar paginas ya almacenadas en la base de datos y que sean accesibles
    for pagina in paginas:
        if num_paginas == 0:
            break
        cursor.execute("select count(*) from paginas where URL=%s",(pagina,))
        resultado = cursor.fetchone()
        cantidad=resultado.__getitem__(0)
        #Si el resultado es 0 se comprueba y se añade en caso de que se pueda acceder a ella
        if cantidad==0:
            if comprobarAccesoPagina(pagina,0): 
                #Se guardan las páginas que han pasado los filtros
                cursor.execute("insert into paginas(sitio_id,URL) values(%s,%s)",(sitio_id,pagina,))
                paginas_validas.append(pagina)
                num_paginas = num_paginas - 1 #Se reduce el número de páginas a buscar
    
    #Realizamos el proceso de desconexión de la base de datos y cerramos el driver del modo headless
    conexion.commit()
    driver.quit()

    #Llamada recursiva
    for pagina in paginas_validas:
        if num_paginas == 0:
            return 0
        else:
            num_paginas= getPaginas(sitio_id,pagina,num_paginas,profundidad+1,conexion,cursor)

    return num_paginas

#Argumentos
sitio_id=sys.argv[1]
num_paginas=int(sys.argv[2])

#Conexion Base de datos
parametros = conexionDB()
conexion= parametros[0]
cursor = parametros[1]

url=getURL(sitio_id,cursor)

getPaginas(sitio_id,url,num_paginas,0,conexion,cursor)

desconexionDB(conexion)

