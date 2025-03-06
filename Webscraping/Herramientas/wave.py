import json, requests, sys, os

directorio_import = os.path.dirname(os.path.abspath(__file__))
directorio_import = directorio_import.replace('/Herramientas','')
sys.path.append(directorio_import)

from database import conexionBD,desconexionBD
from herramienta import getDirectorioOSAW,getFecha, getRutaReporte, getCabeceraReporte, errorLog

from keys import WAVE_KEY


#Obtenemos los datos a guardar en el reporte
def getDatos(categoria,datos,reporte):
    try:
        reporte.write(categoria+"\n\n")
        valores = datos.values()
        for v in valores:
            reporte.write(str(v["description"]) +"\t  VECES ENCONTRADO: "+ str(v["count"])+"\n")
        reporte.write("\n\n")
        
    except Exception as e:
        pass

#Método para ejecutar el proceso de evaluación
def ejecutarWAVE(pagina_id,pagina_url,herramienta,conexion,cursor):

    directorio = getDirectorioOSAW()
    fecha_test=getFecha()
    try:
        #URL para la petición del informe a la API de WAVE
        url_request="http://wave.webaim.org/api/request?key="+key+"&url="+pagina_url+"&format=json&reporttype=2"
        
        r = requests.get(url=url_request,timeout=15)

        #Decodificamos los datos obtenidos
        datos_json=json.loads(r.content.decode('utf-8'))

        #Comprobamos que la respuesta tiene el formato correcto.
        exito = True
        try:
            exito=datos_json["success"]
        except Exception as e:
            pass
            
        if exito:
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
                getDatos("-PROBLEMAS-",datos_json["categories"]["error"]["items"],reporte)
            except Exception as e:
                pass
            try:
                getDatos("-ALERTAS-",datos_json["categories"]["alert"]["items"],reporte)
            except Exception as e:
                pass
            try:
                getDatos("-CARACTERISTICAS-",datos_json["categories"]["feature"]["items"],reporte)
            except Exception as e:
                pass
            try:
                getDatos("-PROBLEMAS DE CONTRASTE-",datos_json["categories"]["contrast"]["items"],reporte)
            except Exception as e:
                pass

            reporte.close()

            cursor=cursor.execute("insert into waves(pagina_id,num_problemas, num_advertencias, num_caracteristicas, num_elem_ARIA, num_problemas_contraste,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),num_problemas, num_advertencias, num_caracteristicas, num_elem_ARIA, num_problemas_contraste,ruta_BD,fecha_test,))
            
            desconexionBD(conexion)

        else:
            raise Exception('No se ha podido realizar la evaluación. Formato de respuesta incorrecto')

    except Exception as e:
        errorLog(directorio,fecha_test,herramienta,pagina_id,e)

#Argumentos URL e ID de la página web
pagina_id=sys.argv[1]
pagina_url=sys.argv[2]

herramienta="wave"
key=WAVE_KEY

#Conexión base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

ejecutarWAVE(pagina_id,pagina_url,herramienta,conexion,cursor)
desconexionBD(conexion)