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

fecha=str(datetime.now().date())

try:
    #Formato de la URL para utilizar la API de la herramienta
    url_request="http://observatorioweb.ups.edu.ec/oaw/srv/wcag/json/conformidad/?url="+pagina_url+"&key="+key
    
    r = requests.get(url=url_request)

    datos_json=json.loads(r.content.decode('utf-8'))

    #Número de problemas y advertencias por principio
    problemas_comprensible=datos_json["oaw"]["resultado"]["resumen"]["comprensible"]["errores"]
    advertencias_comprensible=datos_json["oaw"]["resultado"]["resumen"]["comprensible"]["advertencias"
    ]
    problemas_operable=datos_json["oaw"]["resultado"]["resumen"]["operable"]["errores"]
    advertencias_operable=datos_json["oaw"]["resultado"]["resumen"]["operable"]["advertencias"]

    problemas_perceptible=datos_json["oaw"]["resultado"]["resumen"]["perceptible"]["errores"]
    advertencias_perceptible=datos_json["oaw"]["resultado"]["resumen"]["perceptible"]["advertencias"]

    problemas_robusto=datos_json["oaw"]["resultado"]["resumen"]["robusto"]["errores"]
    advertencias_robusto=datos_json["oaw"]["resultado"]["resumen"]["robusto"]["advertencias"]


    #Porcentajes principios
    porcentaje_comprensible=datos_json["oaw"]["resultado"]["resumen"]["totalComprensible"]
    porcentaje_operable=datos_json["oaw"]["resultado"]["resumen"]["totalOperable"]
    porcentaje_perceptible=datos_json["oaw"]["resultado"]["resumen"]["totalPerceptible"]
    porcentaje_robusto=datos_json["oaw"]["resultado"]["resumen"]["totalRobusto"]

    ruta_archivo_datos=directorio+"/storage/"+herramienta+"/"+pagina_id+"_"+fecha
    
    

except Exception as e:

    ruta_archivo_logs=directorio+"/storage/logs/log.txt"

    log = open(ruta_archivo_logs, 'a')  
    log.write("[3]Error herramienta: " + herramienta + "- Fecha: "+ fecha+"- Pagina web: " + pagina_url)

