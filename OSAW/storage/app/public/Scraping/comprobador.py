import io, mysql.connector, os, requests

from conexiones import *
from hasher import *
from selenium import webdriver

#Comprobar acceso y el tipo de la URL
def comprobarAccesoyTipo(pagina_web):
    try:
        request = requests.get(pagina_web)
        tipo = request.headers.get('content-type')
        
        #Formato: text/html;charset=utf-8
        tipo = tipo.lower()
        tipo = tipo.replace(' ','')

        if request.status_code == 200 and tipo == "text/html;charset=utf-8":
            return True
        else:
            return False
    except requests.ConnectionError:
        return False

#Comprobar contenido HTML
def comprobarHTML(pagina_id):

    #Conexión base de datos
    parametros = conexionBD()

    conexion= parametros[0]
    cursor = parametros[1]

    cursor.execute("select URL, hash from paginas where id = %s", (pagina_id,))
    pagina = cursor.fetchone()
    
    URL=pagina.__getitem__(0)
    hash_antiguo=pagina.__getitem__(1)

    #Headless browser
    options = webdriver.ChromeOptions()
    options.binary_location = '/usr/bin/google-chrome'
    options.add_argument('headless')

    driver = webdriver.Chrome(chrome_options=options)

    driver.get(URL)

    #Rutas para guardar el archivo desde la carpeta Scraping en la del proyecto Laravel:
    directorio = os.path.dirname(os.path.abspath(__file__))
    directorio=directorio.replace("/Scraping","")
    directorio=directorio.replace("/storage/app","")

    ruta_archivo_antiguo=directorio+"/storage/paginas/"+str(pagina_id)+".html"
    ruta_archivo_nuevo=directorio+"/storage/paginas/"+str(pagina_id)+"_nuevo.html"
    
    #Guardamos el contenido de la página web
    with io.open(ruta_archivo_nuevo, 'w') as f:
        f.write(driver.page_source)

    #Obtenemos el hash del nuevo contenido
    hash_nuevo=hashArchivo(ruta_archivo_nuevo)

    #Si no es la primera vez que se evalua la página (valor en default)
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
            return False #Devolvemos falso indicando que es necesario evaluar la pagina
        else:
            #Si no hay ningun cambio borramos el archivo creado
            os.remove(ruta_archivo_nuevo)
    else:
        #Como es la primera vez que se evalua la página se guarda el contenido y el hash obtenido
        os.rename(ruta_archivo_nuevo,ruta_archivo_antiguo)

        ruta_BD="/storage/paginas/"+str(pagina_id)+".html"

        cursor.execute("update paginas set hash=%s,archivo_html=%s where id=%s",(hash_nuevo,ruta_BD,pagina_id,))
        conexion.commit()

    driver.quit()
    desconexionBD(conexion,cursor)
    return True
