import json
import io
import subprocess
import sys
import mysql.connector

from selenium import webdriver
from conexiones import *

#Método para llamar las herramientas
def evaluarPagina(am,ac,e,u,v,w,pagina_web):
    if am == True:
        comando="python3 Herramientas/accessmonitor.py " + str(pagina_web)
        subprocess.run(comando, shell=True, check=True)
    if ac == True:
        comando="python3 Herramientas/achecker.py " + str(pagina_web)
        subprocess.run(comando, shell=True, check=True)
    if e == True:
        comando="python3 Herramientas/eiiichecker.py " + str(pagina_web)
        subprocess.run(comando, shell=True, check=True)
    if u == True:
        comando="python3 Herramientas/ups.py " + str(pagina_web)
        subprocess.run(comando, shell=True, check=True)
    if v == True:
        comando="python3 Herramientas/vamola.py " + str(pagina_web)
        subprocess.run(comando, shell=True, check=True)
    if w == True:
        comando="python3 Herramientas/wave.py " + str(pagina_web)
        subprocess.run(comando, shell=True, check=True)
        



#Argumento sys.argv[1] -> id del sitio web
id_sitio=sys.argv[1]

#Conexión base de datos
parametros = conexionBD()

conexion= parametros[0]
cursor = parametros[1]

#Obtenenemos la periodicidad y las herramientas utilizadas para evaluar el sitio en cuestión
cursor.execute("select periodicidad_analisis, herramientas from sitios where id = %s", (id_sitio,))

sitio = cursor.fetchone()

periodicidad=sitio.__getitem__(0)
herramientas=sitio.__getitem__(1)

#Comprobamos las páginas web en caso de que sea necesario analizarlas o no
cursor.execute("select * from paginas where sitio_id = %s", (id_sitio,))
filas = cursor.fetchall()

for fila in filas:
    #Llamada a crawler: comprobar acceso y copia HTML
    print(fila.__getitem__(0))

   
'''
#BASE DE DATOS
url="http://accesibilidadweb.dlsi.ua.es/"

parametros = conexionBD()

conexion= parametros[0]
cursor = parametros[1]

#cursor.execute("insert into sitios(idSitio,url) values(4,%s)",(url,))

lista = ["aaaaaaaaaaaaa","aaaaaaaaaaaaa","aaaaaaaaaaaaa","aaaaaaaaaaaaa"]

for i in lista:
    cursor.execute("insert into sitios(url) values(%s)",(i,))



cursor.execute("select idSitio from sitios where url = %s", ("http://www.elmundo.es",))

idSitio = cursor.fetchone()

print(idSitio.__getitem__(0))


desconexionBD(conexion,cursor)


#HEADLESS
options = webdriver.ChromeOptions()

options.binary_location = '/usr/bin/google-chrome'
options.add_argument('headless')

#Pruebas
#options.add_argument('window-size=1200x600')

driver = webdriver.Chrome(chrome_options=options)

#Accedemos a la web de la herramienta de evaluacion
driver.get('http://www.google.com')


#Guardamos la informacion obtenida en un archivo html resultado
with io.open('/home/jesus/google.html', 'w') as f:
    f.write(driver.page_source)


'''