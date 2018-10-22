import io, json, mysql.connector, subprocess, sys

from selenium import webdriver
from conexiones import *
from checkPagina import *


#Método para llamar las herramientas
def ejecutarHerramienta(herramienta_eval,herramienta,pagina_web,pagina_id):
    if herramienta_eval == True:
        comando="python3 herramientas/"+herramienta+".py " + str(pagina_web)+" "+ pagina_id
        print(comando)
        #subprocess.run(comando, shell=True, check=True)



#Argumento sys.argv[1] -> id del sitio web
sitio_id=sys.argv[1]

#Listado con los nombres de las herramientas
lista_herramientas=["accessmonitor","achecker","eiiichecker","ups","vamola","wave"]

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
    if checkAcceso(pagina_url):
        #Comprobar cambios en la página web por si es necesario evaluar
        if checkHTML(pagina_id):
        #if checkHTML(pagina_id,pagina_url):
            for l in lista_herramientas:
                ejecutarHerramienta(herramientas[l],l,pagina_url,pagina_id)
    else:
        #Añadir error en log.txt
        print("URL no accesible")


desconexionBD(conexion,cursor)

