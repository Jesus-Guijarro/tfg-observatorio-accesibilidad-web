import io, json, mysql.connector, os, subprocess, sys

from selenium import webdriver
from database import connectionDB,disconnectionDB
from checker import checkAccessAndType, checkHTMLCopy
from tool import getDirectoryOSAW, getToolRoute, copyOldData, getDate, errorLog

#Argumento sys.argv[1] -> id del sitio web
sitio_id=sys.argv[1]

#Listado con las herramientas disponibles para ser usadas
lista_herramientas=["vamola"]

#Método para llamar las herramientas
def runTool(herramienta_eval,herramienta,pagina_url,pagina_id):
    if herramienta_eval:
        #Primero se obtiene el directorio actual para crear el comando a ejecutar
        directorio = getDirectoryOSAW()
        
        ruta_herramienta=getToolRoute(directorio,herramienta)

        pagina_id=int(pagina_id)

        if pagina_id == 1:
            pagina_url=str(pagina_url)
            try:
                subprocess.run(["/usr/bin/python3",ruta_herramienta,pagina_url,str(pagina_id)])
            except Exception as e:
                pass

#Conexión base de datos
parametros = connectionDB()
conexion= parametros[0]
cursor = parametros[1]

#Obtenenemos las herramientas seleccionadas para evaluar el sitio web en cuestión
cursor.execute("select herramientas from sitios where id = %s", (sitio_id,))

sitio = cursor.fetchone()
herramientas=json.loads(sitio.__getitem__(0)) #Se decodifica el JSON

#Comprobamos las páginas web en caso de que sea necesario analizarlas o no
cursor.execute("select URL,id from paginas where sitio_id = %s", (sitio_id,))
paginas = cursor.fetchall()

for pagina in paginas:
    pagina_url=pagina.__getitem__(0)
    pagina_id=str(pagina.__getitem__(1))

    #Comprobar acceso a la página web
    if checkAccessAndType(pagina_url):
        #Comprobar cambios en la página web por si es necesario evaluar
        if checkHTMLCopy(pagina_id):
            for l in lista_herramientas:
                runTool(herramientas[l],l,pagina_url,pagina_id)
        else:
            for l in lista_herramientas:
                copyOldData(herramientas[l],l,pagina_id,cursor)
                
    else:
        #Añadir error en log.txt
        directorio = getDirectoryOSAW()
        fecha_test=getDate()

        errorLog(directorio,3,fecha_test,"",pagina_id,"")

disconnectionDB(conexion)


