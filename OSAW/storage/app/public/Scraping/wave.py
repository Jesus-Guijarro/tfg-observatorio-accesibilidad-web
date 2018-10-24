import json, requests, io, sys, os

from datetime import datetime
from conexiones import *

#Argumentos URL e ID de la página web
pagina_url=sys.argv[1]
pagina_id=sys.argv[2]

herramienta="wave"
key="qbw26Imi1068"

#Conexión base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

#Ruta del directorio actual
directorio = os.path.dirname(os.path.abspath(__file__))

directorio=directorio.replace("/Scraping","")
directorio=directorio.replace("/storage/app","")

fecha_test=str(datetime.now().date())

url_request='http://wave.webaim.org/api/request?key={yourAPIkey}&url={url}&format=json&reporttype=2'

request = requests.get(url=url_request)

datos= json.loads(request.content.decode('utf-8'))

#print(datos["status"]["success"])

with io.open('archivo.txt', 'w') as f:
    f.write(json.dumps(datos))