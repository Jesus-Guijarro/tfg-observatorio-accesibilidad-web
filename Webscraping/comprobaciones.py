import io, mysql.connector, os, requests, hashlib, codecs, logging

from database import conexionBD,desconexionBD
from selenium import webdriver
from herramienta import driverHeadlessBrowser,getFecha, getDirectorioOSAW, getRutaCopiaHTML
from datetime import datetime

def errorLog(pagina_web,pagina_id,error):
    #Para que no se escriban logs durante la ejecución crawler.py se indica pagina_id=0 
    if pagina_id !=0:

        fecha_test=getFecha()
        directorio=getDirectorioOSAW()

        ruta_archivo_logs=directorio+"/logs/paginas/log_paginas_"+fecha_test+".log"

        logging.basicConfig(filename=ruta_archivo_logs,level=logging.WARNING,format='%(asctime)s - %(levelname)s - %(name)s\n\t%(message)s', datefmt='%m/%d/%Y %I:%M:%S %p')
        logger = logging.getLogger("ACCESSO_PAGINA_WEB")

        logger.warning('IDENTIFICADOR: '+str(pagina_id)+'\n\tPAGINA_WEB: '+pagina_web + '\n\tINFORMACION: "'+error+ '"')

#Función para comprobar el tipo del contenido obtenido en la respuesta 
#Realizada para el crawler
def comprobarTipoContenido(tipo,pagina_web,pagina_id):
    if "text/html" in tipo:
        return True
    else:
        error="El tipo de contenido no es text/html"
        errorLog(pagina_web,pagina_id,error)
        return False

def comprobarContenido(contenido,pagina_web,pagina_id):
    contenido=str(contenido).replace(' ','')

    if len(contenido) > 40:
        return True
    else:
        if pagina_id !=0:
            error="El tamaño del contenido es inferior al mínimo requerido (40) para ser evaluado"
            errorLog(pagina_web,pagina_id,error)
        return False


#Función para comprobar el código de respuesta de la petición
def comprobarCodigoRespuesta(codigo_respuesta,pagina_web,pagina_id):
    if codigo_respuesta == 200:
        return True
    elif codigo_respuesta == 301: #Redireccion permanente
        error="La pagina se ha redirigido permanentemente [301]"
        errorLog(pagina_web,pagina_id,error)
        return False
    elif codigo_respuesta == 302: #Redirección temporal
        error="La pagina se ha redirigido temporalmente [302]"
        errorLog(pagina_web,pagina_id,error)
        return False
    elif codigo_respuesta == 403: #Acceso prohibido
        error="El acceso a la página no está permitido [403]"
        errorLog(pagina_web,pagina_id,error)
        return False
    else:
        error="No ha habido éxito en la petición"
        errorLog(pagina_web,pagina_id,error)
        return False

#Función principal para comprobar el estado de una URL
def comprobarAccesoPagina(pagina_web,pagina_id):
    try:
        
        #Necesario indicar el User-Agent para no recibir respuesta 403
        headers = {'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.80 Safari/537.36'}
        #No se verifica el certificado SSL de la web - UMH
        #No se permiten las redirecciones
        peticion = requests.get(pagina_web,headers=headers, verify=False, allow_redirects=False, timeout=20)

        codigo_respuesta=peticion.status_code

        if comprobarCodigoRespuesta(codigo_respuesta,pagina_web,pagina_id):

            tipo= peticion.headers.get('content-type')

            contenido=peticion.text

            if comprobarTipoContenido(tipo,pagina_web,pagina_id) and comprobarContenido(contenido,pagina_web,pagina_id):
                return True
            else:
                return False
        else:
            return False

    except Exception as e:
        error="No se puede acceder a la página. Error: " + repr(e)
        errorLog(pagina_web,pagina_id,error)
        return False


#Función para obtener el valor hash de una copia HTML
def getHASH(ruta_archivo):
    #Se obtiene el contenido del archivo html
    f=codecs.open(ruta_archivo, 'r', encoding="utf8")
    contenido=f.read()

    #Se transforma el contenido con el algoritmo críptográfico MD5
    hash = hashlib.md5()
    hash.update(('%s' % (contenido)).encode('utf-8'))
    valor_hash= hash.hexdigest()

    #16 de los 32 caracteres
    valor_hash= valor_hash[0:16]

    return valor_hash

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
    driver=driverHeadlessBrowser()
    #Accedemos a la página web
    driver.get(URL)

    #Rutas para guardar el archivo desde la carpeta Webscraping en la del proyecto Laravel:
    directorio = getDirectorioOSAW()
    ruta_archivo_antiguo=getRutaCopiaHTML(directorio,pagina_id, "")
    ruta_archivo_nuevo=getRutaCopiaHTML(directorio,pagina_id, "_") #Se añade el carácter '_' para no sobrescribir la copia HTML antigua
    
    #Guardamos el contenido de la página web
    with io.open(ruta_archivo_nuevo, 'w') as f:
        f.write(driver.page_source)

    #Obtenemos el hash del nuevo contenido
    hash_nuevo=getHASH(ruta_archivo_nuevo)

    #Si no es la primera vez que se evalua la página (valor:"manual")
    if hash_antiguo!="default":
        #Si los hash tienen valores distintos y no es una página vacia
        
        if hash_antiguo != hash_nuevo:
            #Borramos el archivo anterior
            os.remove(ruta_archivo_antiguo)
            #Cambiamos el nombre del archivo nuevo para tener el nombre del antiguo
            os.rename(ruta_archivo_nuevo,ruta_archivo_antiguo)
            #Actualizamos la pagina con su nuevo valor hash
            cursor.execute("update paginas set hash=%s where id=%s",(hash_nuevo,pagina_id,))
            conexion.commit()

            driver.quit()
            desconexionBD(conexion)
            return True #Devolvemos true indicando que es necesario evaluar la pagina
        #Si no hay ningun cambio borramos el archivo creado
        else:
            os.remove(ruta_archivo_nuevo)
            return False
    #Como es la primera vez que se evalua la página, se guarda el contenido y el hash obtenidos
    else:
        os.rename(ruta_archivo_nuevo,ruta_archivo_antiguo)
        
        ruta_BD=getRutaCopiaHTML("",pagina_id, "")

        cursor.execute("update paginas set hash=%s,archivo_html=%s where id=%s",(hash_nuevo,ruta_BD,pagina_id,))

    driver.quit()
    desconexionBD(conexion)
    return True
