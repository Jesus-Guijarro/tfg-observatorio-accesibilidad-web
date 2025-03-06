import io, mysql.connector, os, sys

from database import conexionBD,desconexionBD
from comprobaciones import comprobarAccesoPagina, comprobarCopiaHTML
from herramienta import copiarDatosAntiguos, ejecutarHerramienta


#Método principal encargado de realizar la evaluación del sitio: checker y llamadas a las herramientas
def ejecutar(sitio_id,herramientas_sitio,conexion,cursor):

    #Comprobamos las páginas web en caso de que sea necesario analizarlas o no
    cursor.execute("select URL,id from paginas where sitio_id = %s", (sitio_id,))
    paginas = cursor.fetchall()

    for pagina in paginas:
        pagina_url=pagina.__getitem__(0)
        pagina_id=str(pagina.__getitem__(1))

        #Comprobar acceso a la página web
        if comprobarAccesoPagina(pagina_url,pagina_id):
            #Comprobar cambios en la página web por si es necesario evaluar
            if comprobarCopiaHTML(pagina_id):
                for herramienta in herramientas_sitio:
                    ejecutarHerramienta(herramienta,pagina_id,pagina_url)
            else:
                for herramienta in herramientas_sitio:
                    copiarDatosAntiguos(herramienta,pagina_url,pagina_id,cursor)
                    
#Argumento sys.argv[1] -> id del sitio web
sitio_id=sys.argv[1]

#Conexión base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

#Listado con las herramientas activas para ser usadas
cursor.execute("SELECT nombre FROM herramienta_sitio hs, herramientas h where h.activa=%s and hs.sitio_id=%s and h.id=hs.herramienta_id", (True,sitio_id,))
herramientas = cursor.fetchall()

herramientas_sitio=[]

for herramienta in herramientas:
    herramientas_sitio.append(str(herramienta.__getitem__(0)))

ejecutar(sitio_id,herramientas_sitio,conexion,cursor)
desconexionBD(conexion)