import io, mysql.connector, os, requests

from conexiones import *
from hasher import hashArchivo
from selenium import webdriver
from miscelaneo import modoHeadless, getDirectorio, getRutaCopiaHTML

#Función para comprobar que la referencia tiene un formato: https://dominio... o http://dominio y que no incluye el símbolo /# de menús y submenús de navegación
def comprobarReferencia(href, sitio_url):
    if href.find(sitio_url)!=-1 and href.find(sitio_url,0,len(sitio_url))!=-1 and '#' not in href: #El '#' es por la herramienta observatorio.py
        return True
    return False

#Comprobar acceso y el tipo de la URL
def comprobarAccesoyTipo(pagina_web):
    try:
        request = requests.get(pagina_web)
        tipo = request.headers.get('content-type')

        #Tipo de contenido buscado -> "text/html"
        tipo = tipo.lower().replace(' ','')

        #Comprobamos si obtenemos respuesta satisfactoria y el tipo del contenido es text/html
        if request.status_code == 200 and "text/html" in tipo:
            return True
        else:
            return False
    except requests.ConnectionError:
        return False

#Comprobar contenido HTML
def comprobarCopiaHTML(pagina_id):

    #Conexión base de datos
    parametros = conexionBD()
    conexion= parametros[0]
    cursor = parametros[1]

    #Buscamos la URL y Hash actual de la página web
    cursor.execute("select URL, hash from paginas where id = %s", (pagina_id,))
    pagina = cursor.fetchone()
    
    URL=pagina.__getitem__(0)
    hash_antiguo=pagina.__getitem__(1)

    #Activamos el modo headless browser
    driver=modoHeadless()
    #Accedemos a la página web
    driver.get(URL)

    #Rutas para guardar el archivo desde la carpeta web-scraping en la del proyecto Laravel:
    directorio = getDirectorio()
    ruta_archivo_antiguo=getRutaCopiaHTML(directorio,pagina_id, "")
    ruta_archivo_nuevo=getRutaCopiaHTML(directorio,pagina_id, "_") #Se añade el carácter '_' para no sobrescribir la copia HTML antigua
    
    #Guardamos el contenido de la página web
    with io.open(ruta_archivo_nuevo, 'w') as f:
        f.write(driver.page_source)

    #Obtenemos el hash del nuevo contenido
    hash_nuevo=hashArchivo(ruta_archivo_nuevo)

    #Si no es la primera vez que se evalua la página (valor:"manual")
    if hash_antiguo!="default":
        #Si los hash tienen valores distintos
        if hash_antiguo != hash_nuevo:
            #Borramos el archivo anterior
            os.remove(ruta_archivo_antiguo)
            #Cambiamos el nombre del archivo nuevo para tener el nombre del antiguo
            os.rename(ruta_archivo_nuevo,ruta_archivo_antiguo)
            #Actualizamos la pagina con su nuevo valor hash
            cursor.execute("update paginas set hash=%s where id=%s",(hash_nuevo,pagina_id,))
            conexion.commit()

            driver.quit()
            desconexionBD(conexion,cursor)
            return True #Devolvemos true indicando que es necesario evaluar la pagina
        else:
            #Si no hay ningun cambio borramos el archivo creado
            os.remove(ruta_archivo_nuevo)
            return False
    else:
        #Como es la primera vez que se evalua la página se guarda el contenido y el hash obtenido
        os.rename(ruta_archivo_nuevo,ruta_archivo_antiguo)
        
        ruta_BD=getRutaCopiaHTML("",pagina_id, "")

        cursor.execute("update paginas set hash=%s,archivo_html=%s where id=%s",(hash_nuevo,ruta_BD,pagina_id,))

    driver.quit()
    desconexionBD(conexion,cursor)
    return True
