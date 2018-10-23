import json, requests, io, sys, os

from datetime import datetime
from conexiones import *

#Argumentos URL e ID de la página web
pagina_url=sys.argv[1]
pagina_id=sys.argv[2]

herramienta="ups"
key="b83e8400-5431-4b2b-8de8-4806a90fc418"


#Conexión base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

#Ruta del directorio actual
directorio = os.path.dirname(os.path.abspath(__file__))

directorio=directorio.replace("/Scraping/herramientas","")
directorio=directorio.replace("/storage/app","")


try:
    #Formato de la URL para utilizar la API de la herramienta
    url_request="http://observatorioweb.ups.edu.ec/oaw/srv/wcag/json/conformidad/?url="+pagina_url+"&key="+key
    
    r = requests.get(url=url_request)

    datos=json.loads(r.content.decode('utf-8'))

    fecha=str(datetime.now().date())

    ruta_archivo_datos=directorio+"/storage/"+herramienta+"/"+pagina_id+"_"+fecha
    

except Exception as e:
    print(e.__doc__)
    print(e.message)

'''
r = requests.get(url='http://observatorioweb.ups.edu.ec/oaw/srv/wcag/json/conformidad/?url=http://www.elmundo.es&key=b83e8400-5431-4b2b-8de8-4806a90fc418')

datos= json.loads(r.content.decode('utf-8'))

#print(datos["oaw"]["fecha"])


with io.open('archivo.txt', 'w') as f:
    f.write(json.dumps(datos))
'''