import json, requests, sys

from conexiones import *
from miscelaneo import getDirectorio,getFecha, getRutaReporte, cabeceraReporte, errorLog

#Argumentos URL e ID de la página web
pagina_url=sys.argv[1]
pagina_id=sys.argv[2]

herramienta="wave"
key="qbw26Imi1068"

fecha_test=getFecha()

#Conexión base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

#Rutas
directorio = getDirectorio()
ruta_reporte=getRutaReporte(directorio,herramienta,pagina_id,fecha_test)
ruta_BD=getRutaReporte("",herramienta,pagina_id,fecha_test)

try:
    #URL para la petición del informe a la API de WAVE
    url_request="http://wave.webaim.org/api/request?key="+key+"&url="+pagina_url+"&format=json&reporttype=2"
    r = requests.get(url=url_request)
    #Decodificamos los datos obtenidos
    datos_json=json.loads(r.content.decode('utf-8'))

    #Obtenemos los números de las distintas categorias
    num_problemas = datos_json["categories"]["error"]["count"]
    num_advertencias= datos_json["categories"]["alert"]["count"]
    num_caracteristicas= datos_json["categories"]["feature"]["count"]
    num_elem_ARIA= datos_json["categories"]["html5"]["count"]
    num_problemas_contraste= datos_json["categories"]["contrast"]["count"]

    #Creamos el reporte 
    reporte = open(ruta_reporte, 'a')
    reporte.write(cabeceraReporte(pagina_url,fecha_test))

    #Obtenemos los datos a guardar en el reporte
    def getDatos(categoria,datos):
        valores = datos.values()
        #claves = datos.keys()
        reporte.write(categoria+"\n")
        for v in valores:
            reporte.write(str(v["description"]) +"\t  VECES ENCONTRADO: "+ str(v["count"])+"\n")
        reporte.write("-------------------------------------------------------------------\n")

    #En algunas ocasiones una o varias de las categorias no tiene elementos accesibles
    try:
        getDatos("PROBLEMAS",datos_json["categories"]["error"]["items"])
    except Exception as e:
        pass
    try:
        getDatos("ALERTAS",datos_json["categories"]["alert"]["items"])
    except Exception as e:
        pass
    try:
        getDatos("CARACTERISTICAS",datos_json["categories"]["feature"]["items"])
    except Exception as e:
        pass
    try:
        getDatos("PROBLEMAS DE CONTRASTE",datos_json["categories"]["contrast"]["items"])
    except Exception as e:
        pass

    cursor=cursor.execute("insert into waves(pagina_id,num_problemas, num_advertencias, num_caracteristicas, num_elem_ARIA, num_problemas_contraste,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),num_problemas, num_advertencias, num_caracteristicas, num_elem_ARIA, num_problemas_contraste,ruta_BD,fecha_test,))
    reporte.close()
    desconexionBD(conexion,cursor)

except Exception as e:
        errorLog(directorio,1,getFecha(),herramienta,pagina_id,e)
