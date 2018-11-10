import json, requests, sys

from database import conexionBD,desconexionBD
from herramienta import getDirectorio,getFecha, getRutaReporte, getCabeceraReporte, errorLog

#Obtenemos los datos a guardar en el reporte
def getDatos(categoria,datos,reporte):
    valores = datos.values()
    reporte.write(categoria+"\n")
    for v in valores:
        reporte.write(str(v["description"]) +"\t  VECES ENCONTRADO: "+ str(v["count"])+"\n")
    reporte.write("-------------------------------------------------------------------\n")

#Método para ejecutar el proceso de evaluación
def ejecutarWAVE(pagina_id,pagina_url,herramienta,conexion,cursor):

    directorio = getDirectorio()
    fecha_test=getFecha()
    try:
        #URL para la petición del informe a la API de WAVE
        url_request="http://wave.webaim.org/api/request?key="+key+"&url="+pagina_url+"&format=json&reporttype=2"
        r = requests.get(url=url_request)
        #Decodificamos los datos obtenidos
        datos_json=json.loads(r.content.decode('utf-8'))

        #La API no sigue un esquema común para las URLs que se han podido analizar y las que no.
        exito = True

        #El formato del JSON devuelto depende de si ha habido éxito o no. Sólo comprobamos si ha fallado
        try:
            exito=datos_json["success"]
        except Exception as e:
            pass

        if exito :
            #Obtenemos los números de las distintas categorias
            num_problemas = datos_json["categories"]["error"]["count"]
            num_advertencias= datos_json["categories"]["alert"]["count"]
            num_caracteristicas= datos_json["categories"]["feature"]["count"]
            num_elem_ARIA= datos_json["categories"]["html5"]["count"]
            num_problemas_contraste= datos_json["categories"]["contrast"]["count"]

            #Rutas para guardar el archivo y el acceso desde la BD
            ruta_reporte=getRutaReporte(directorio,herramienta,pagina_id,fecha_test)
            ruta_BD=getRutaReporte("",herramienta,pagina_id,fecha_test)

            #Creamos el reporte 
            reporte = open(ruta_reporte, 'a')
            reporte.write(getCabeceraReporte(pagina_url,fecha_test))

            #En algunas ocasiones una o varias de las categorias no tiene elementos accesibles
            try:
                getDatos("PROBLEMAS",datos_json["categories"]["error"]["items"],reporte)
            except Exception as e:
                pass
            try:
                getDatos("ALERTAS",datos_json["categories"]["alert"]["items"],reporte)
            except Exception as e:
                pass
            try:
                getDatos("CARACTERISTICAS",datos_json["categories"]["feature"]["items"],reporte)
            except Exception as e:
                pass
            try:
                getDatos("PROBLEMAS DE CONTRASTE",datos_json["categories"]["contrast"]["items"],reporte)
            except Exception as e:
                pass

            reporte.close()

            cursor=cursor.execute("insert into waves(pagina_id,num_problemas, num_advertencias, num_caracteristicas, num_elem_ARIA, num_problemas_contraste,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),num_problemas, num_advertencias, num_caracteristicas, num_elem_ARIA, num_problemas_contraste,ruta_BD,fecha_test,))
            
            desconexionBD(conexion)

    except Exception as e:
            errorLog(directorio,1,getFecha(),herramienta,pagina_id,e)

#Argumentos URL e ID de la página web
pagina_id=sys.argv[1]
pagina_url=sys.argv[2]

herramienta="wave"
key="qbw26Imi1068"

#Conexión base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

ejecutarWAVE(pagina_id,pagina_url,herramienta,conexion,cursor)
desconexionBD(conexion)