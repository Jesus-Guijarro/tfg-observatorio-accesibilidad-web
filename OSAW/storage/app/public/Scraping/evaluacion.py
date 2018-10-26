import io, json, mysql.connector, subprocess, sys

from selenium import webdriver
from conexiones import *
from comprobador import *
from miscelaneo import *

#Argumento sys.argv[1] -> id del sitio web
sitio_id=sys.argv[1]

#Listado con las herramientas disponibles para ser usadas
lista_herramientas=["accessmonitor","achecker","eiiichecker","observatorio","vamola","wave"]

#Método para llamar las herramientas
def ejecutarHerramienta(herramienta_eval,herramienta,pagina_web,pagina_id):
    if herramienta_eval:
        
        #Primero se obtiene el directorio actual para crear el comando a ejecutar
        directorio = getDirectorio()

        comando="/usr/bin/python3 "+getRutaComando(directorio,herramienta,pagina_web,pagina_id)
        print(comando)
        #subprocess.run(comando, shell=True, check=True)

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

    #Comprobar acceso a la página web
    if comprobarAccesoyTipo(pagina_url):
        #Comprobar cambios en la página web por si es necesario evaluar
        if comprobarCopiaHTML(pagina_id):
            for l in lista_herramientas:
                ejecutarHerramienta(herramientas[l],l,pagina_url,pagina_id)
    else:
        #Añadir error en log.txt
        directorio = getDirectorio()
        fecha_test=getFecha()
        
        errorLog(directorio,3,fecha_test,"",pagina_id,"")

desconexionBD(conexion,cursor)

