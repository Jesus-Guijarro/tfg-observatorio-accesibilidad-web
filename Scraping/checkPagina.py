
import io, mysql.connector, os, requests

from conexiones import *
from hashHTML import *

from selenium import webdriver

#Comprobar acceso URL
def checkAcceso(pagina_web):
    try:
        request = requests.get(pagina_web)

        if request.status_code == 200:
            return True
        else:
            return False
    except requests.ConnectionError:
        return False

#Comprobar contenido HTML
def checkHTML(pagina_id):

    #Conexión base de datos
    parametros = conexionBD()

    conexion= parametros[0]
    cursor = parametros[1]

    cursor.execute("select URL, archivo_HTML, hash from paginas where id = %s", (pagina_id,))
    pagina = cursor.fetchone()
    
    URL=pagina.__getitem__(0)
    ruta_archivo_antiguo=pagina.__getitem__(1)
    hash_antiguo=pagina.__getitem__(2)

    #Headless browser
    options = webdriver.ChromeOptions()
    options.binary_location = '/usr/bin/google-chrome'
    options.add_argument('headless')

    driver = webdriver.Chrome(chrome_options=options)

    driver.get(URL)
    driver.implicitly_wait(1)

    #Para poder acceder a las rutas de los archivos desde pytho es necesario poner:
    cabecera_ruta="../OSAW/public"

    ruta_archivo_nuevo="/storage/paginas/"+pagina_id+"2.html"

    #Guardamos el contenido de la página web
    with io.open(cabecera_ruta+ruta_archivo_nuevo, 'w') as f:
        f.write(driver.page_source)

    #Obtenemos el hash del nuevo contenido
    hash_nuevo=crearHASH(cabecera_ruta+ruta_archivo_nuevo)

    #Si no es la primera vez que se evalua la página
    if hash_antiguo!=0:
        #Si los hash tienen valores distintos
        if hash_antiguo != hash_nuevo:
            #Borramos el archivo anterior
            os.remove(cabecera_ruta+ruta_archivo_antiguo)
            #Cambiamos el nombre del archivo nuevo para tener el nombre del antiguo
            os.rename(cabecera_ruta+ruta_archivo_nuevo,ruta_archivo_antiguo)
            #Actualizamos la pagina con su nuevo valor hash
            cursor.execute("update paginas set hash=%s where id=%s",(hash_nuevo,pagina_id,))

            return False #Devolvemos falso indicando que es necesario evaluar la pagina
        else:
            #Si no hay ningun cambio borramos el archivo creado
            os.remove(cabecera_ruta+ruta_archivo_nuevo)
    else:
        #Como es la primera vez que se evalua la página se guarda el contenido y el hash obtenido
        os.rename(cabecera_ruta+ruta_archivo_nuevo,"/storage/paginas/"+pagina_id+".html")

        cursor.execute("update paginas set hash=%s,archivo_html=%s where id=%s",(hash_nuevo,ruta_archivo_nuevo,pagina_id,))

    driver.quit()

    return True
    
#Pruebas
pagina_web="http://www.google.com"
print(checkAcceso(pagina_web))