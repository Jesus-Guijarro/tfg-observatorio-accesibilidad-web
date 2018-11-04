import io, json, mysql.connector, os, subprocess, sys

from selenium import webdriver
from conexiones import *
from comprobaciones import comprobarAccesoyTipo, comprobarCopiaHTML
from miscelaneo import getDirectorio, getRutaHerramienta, copiarDatosAntiguos, getFecha, errorLog

#Argumento sys.argv[1] -> id del sitio web
sitio_id=sys.argv[1]

#Listado con las herramientas disponibles para ser usadas
herramientas_activas=["accessmonitor","achecker","eiiichecker","observatorio","vamola","wave"]

#Conexión base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

#Método para llamar las herramientas
def ejecutarHerramienta(seleccionada,herramienta,pagina_url,pagina_id):
    if seleccionada:
        #Primero se obtiene el directorio actual para crear el comando a ejecutar
        directorio = getDirectorio()
        
        ruta_herramienta=getRutaHerramienta(directorio,herramienta)

        try:
            subprocess.run(["/usr/bin/python3",ruta_herramienta,str(pagina_id),str(pagina_url)])
        except Exception as e:
            pass

def evaluar(sitio_id,herramientas_activas,conexion,cursor):
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
        if comprobarAccesoyTipo(pagina_url):
            #Comprobar cambios en la página web por si es necesario evaluar
            if comprobarCopiaHTML(pagina_id):
                for h in herramientas_activas:
                    ejecutarHerramienta(herramientas[h],h,pagina_url,pagina_id)
            else:
                for h in herramientas_activas:
                    copiarDatosAntiguos(herramientas[h],h,pagina_url,pagina_id,cursor)
                    
        else:
            #Añadir error en log.txt
            directorio = getDirectorio()
            fecha_test=getFecha()

            errorLog(directorio,3,fecha_test,"",pagina_id,"")

evaluar(sitio_id,herramientas_activas,conexion,cursor)
desconexionBD(conexion)