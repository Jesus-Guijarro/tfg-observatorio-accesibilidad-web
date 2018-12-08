import sys
from database import *

#Argumento sys.argv[1] -> id del sitio web
sitio_id=sys.argv[1]

#Conexión base de datos
parametros = conexionDB()
conexion= parametros[0]
cursor = parametros[1]

#Listado con las herramientas activas para ser usadas
cursor.execute("SELECT descripcion FROM herramienta_sitio hs, herramientas h where h.activa=%s and hs.sitio_id=%s and h.id=hs.herramienta_id", (True,sitio_id,))
herramientas = cursor.fetchall()

herramientas_sitio=[]

for herramienta in herramientas:
    herramientas_sitio.append(str(herramienta.__getitem__(0)))


desconexionDB(conexion)