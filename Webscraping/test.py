import io, json, mysql.connector, os, sys

from selenium import webdriver
from database import conexionDB,desconexionDB
from comprobaciones import comprobarAccesoPagina, comprobarCopiaHTML
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

        if int(pagina_id)==231:
            #Comprobar acceso a la página web
            if comprobarAccesoPagina(pagina_url,pagina_id):
                #Comprobar cambios en la página web por si es necesario evaluar
                if comprobarCopiaHTML(pagina_id):
                    for h in herramientas_activas:
                        ejecutarHerramienta(herramientas[h],h,pagina_id,pagina_url)
                else:
                    for h in herramientas_activas:
                        copiarDatosAntiguos(herramientas[h],h,pagina_url,pagina_id,cursor)
                        


#Argumento sys.argv[1] -> id del sitio web
sitio_id=sys.argv[1]



#Conexión base de datos
parametros = conexionDB()
conexion= parametros[0]
cursor = parametros[1]

#Listado con las herramientas activas para ser usadas

cursor.execute("select descripcion from herramientas where activa = %s", (True,))
herramientas = cursor.fetchall()

herramientas_activas=[]

for herramienta in herramientas:
    herramientas_activas.append(str(herramienta.__getitem__(0)))

#herramientas_activas=["eiiichecker"]

run(sitio_id,herramientas_activas,conexion,cursor)
desconexionDB(conexion)

