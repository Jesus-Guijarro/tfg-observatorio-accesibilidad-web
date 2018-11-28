import io, json, mysql.connector, os, sys

from selenium import webdriver
from conexionesBD import conexionBD,desconexionBD
from comprobaciones import comprobarAccesoyTipo, comprobarCopiaHTML
from herramienta import copiarDatosAntiguos, getFecha, getDirectorioOSAW, errorLog, ejecutarHerramienta


#Método principal encargado de realizar la evaluación del sitio: checker y llamadas a las herramientas
def run(sitio_id,herramientas_activas,conexion,cursor):
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

        if int(pagina_id)==40:
            #Comprobar acceso a la página web
            if comprobarAccesoyTipo(pagina_url):
                #Comprobar cambios en la página web por si es necesario evaluar
                if comprobarCopiaHTML(pagina_id):
                    for h in herramientas_activas:
                        ejecutarHerramienta(herramientas[h],h,pagina_id,pagina_url)
                else:
                    for h in herramientas_activas:
                        copiarDatosAntiguos(herramientas[h],h,pagina_url,pagina_id,cursor)
                        
            else:
                fecha_test=getFecha()
                directorio=getDirectorioOSAW()
                errorLog(directorio,2,fecha_test,"",pagina_id,"")


#Argumento sys.argv[1] -> id del sitio web
sitio_id=sys.argv[1]

#Listado con las herramientas disponibles para ser usadas
herramientas_activas=["accessmonitor","achecker","eiiichecker","observatorio","vamola","wave"]
#herramientas_activas=["accessmonitor","achecker","observatorio","vamola","wave"]

#Conexión base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

run(sitio_id,herramientas_activas,conexion,cursor)
desconexionBD(conexion)