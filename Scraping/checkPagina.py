
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

    ruta_archivo_nuevo="/storage/paginas/"+pagina_id+"2.html"

    with io.open(ruta_archivo_nuevo, 'w') as f:
        f.write(driver.page_source)

    hash_nuevo=crearHASH(ruta_archivo_nuevo)

    if hash_antiguo!=0:
        if hash_antiguo != hash_nuevo:
            os.remove(ruta_archivo_antiguo)
            os.rename(ruta_archivo_nuevo,ruta_archivo_antiguo)

            cursor.execute("update paginas set hash=%s where id=%s",(hash_nuevo,pagina_id,))

            return False
        else
            os.remove(ruta_archivo_nuevo)
    else:
        os.rename(ruta_archivo_nuevo,"/storage/paginas/"+pagina_id+".html")
        cursor.execute("update paginas set hash=%s,archivo_html=%s where id=%s",(hash_nuevo,ruta_archivo_nuevo,pagina_id,))

    driver.quit()

    return True
    






#Pruebas
pagina_web="http://www.googlecom"
print(checkAcceso(pagina_web))