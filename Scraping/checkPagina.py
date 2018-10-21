
import io, mysql.connector, requests

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

    #Headless browser
    options = webdriver.ChromeOptions()
    options.binary_location = '/usr/bin/google-chrome'
    options.add_argument('headless')

    driver = webdriver.Chrome(chrome_options=options)

    cursor.execute("select URL, archivo_HTML, hash from paginas where id = %s", (pagina_id,))
    #
    pagina = cursor.fetchone()
    
    URL=pagina.__getitem__(0)
    archivo_HTML_antiguo=pagina.__getitem__(1)
    hash_antiguo=pagina.__getitem__(2)

    driver.get(pagina.__getitem__(0))

    hash_nuevo=crearHASH(archivo_HTML_nuevo)


    






#Pruebas
pagina_web="http://www.googlecom"
print(checkAcceso(pagina_web))