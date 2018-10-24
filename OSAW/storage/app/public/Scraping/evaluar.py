import io, json, mysql.connector, subprocess, sys

from selenium import webdriver
from herramientas.conexiones import *
from comprobarPagina import *

from datetime import datetime

#Listado con las herramientas disponibles para ser usadas
lista_herramientas=["accessmonitor","achecker","eiiichecker","observatorio","vamola","wave"]

#Método para llamar las herramientas
def ejecutarHerramienta(herramienta_eval,herramienta,pagina_web,pagina_id):
    if herramienta_eval == True:
        
        #Primero se obtiene el directorio actual para crear el comando a ejecutar
        directorio = os.path.dirname(os.path.abspath(__file__))
        directorio=directorio.replace("/Scraping","")
        directorio=directorio.replace("/storage/app","")

        comando="/usr/bin/python3 "+directorio+"/herramientas/"+herramienta+".py " + str(pagina_web)+" "+ pagina_id
        print(comando)
        #subprocess.run(comando, shell=True, check=True)

#Argumento sys.argv[1] -> id del sitio web
sitio_id=sys.argv[1]

#Fecha
fecha_test=str(datetime.now().date())

#Conexión base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

#Obtenenemos la periodicidad y las herramientas utilizadas para evaluar el sitio en cuestión
cursor.execute("select periodicidad_analisis, herramientas from sitios where id = %s", (sitio_id,))

sitio = cursor.fetchone()

periodicidad=sitio.__getitem__(0)
herramientas=json.loads(sitio.__getitem__(1)) #Se decodifica el JSON

#Comprobamos las páginas web en caso de que sea necesario analizarlas o no
cursor.execute("select URL,id,archivo_HTML from paginas where sitio_id = %s", (sitio_id,))
paginas = cursor.fetchall()

for pagina in paginas:
    pagina_url=pagina.__getitem__(0)
    pagina_id=str(pagina.__getitem__(1))
    pagina_archivo_HTML=pagina.__getitem__(2)

    #Comprobar acceso a la URL de la página web
    if comprobarAcceso(pagina_url):
        #Comprobar cambios en la página web por si es necesario evaluar
        if comprobarHTML(pagina_id):
        #if comprobarHTML(pagina_id,pagina_url):
            for l in lista_herramientas:
                ejecutarHerramienta(herramientas[l],l,pagina_url,pagina_id)
    else:
        #Añadir error en log.txt
        directorio = os.path.dirname(os.path.abspath(__file__))

        directorio=directorio.replace("/Scraping","")
        directorio=directorio.replace("/storage/app","")

        ruta_archivo_logs=directorio+"/storage/logs/log.txt"
        log = open(ruta_archivo_logs, 'a')  
        log.write("[03]Error accesso página web: " + pagina_url + " ----- Fecha: "+ fecha_test + "\n")


desconexionBD(conexion,cursor)

