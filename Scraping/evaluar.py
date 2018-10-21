import io, json, mysql.connector, subprocess, sys

from selenium import webdriver
from conexiones import *
from checkPagina import *


#Método para llamar las herramientas
def ejecutarHerramienta(herramienta_eval,herramienta,pagina_web):
    if herramienta_eval == True:
        comando="python3 Herramientas/"+herramienta+".py " + str(pagina_web)
        #subprocess.run(comando, shell=True, check=True)

lista_herramientas=["accessmonitor","achecker","eiiichecker","ups","vamola","wave"]

#Argumento sys.argv[1] -> id del sitio web
sitio_id=sys.argv[1]

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
cursor.execute("select * from paginas where sitio_id = %s", (sitio_id,))
filas = cursor.fetchall()

for fila in filas:
    #Llamada a crawler: comprobar acceso y copia HTML
    if True:
        for l in lista_herramientas:
            ejecutarHerramienta(herramientas[l],l,fila.__getitem__(1))



desconexionBD(conexion,cursor)

