import json, requests, sys, os

directorio_import = os.path.dirname(os.path.abspath(__file__))
directorio_import = directorio_import.replace('/Herramientas','')
sys.path.append(directorio_import)

from database import conexionBD,desconexionBD
from herramienta import getDirectorioOSAW,getFecha, getRutaReporte, getCabeceraReporte, errorLog
from keys import OBSERVATORIO_KEY


#Los "isinstance" son para comprobar que el elemento es una lista o un elemento único
#Los try son para ignorar los casos en los que se no se encuentra cierto elemento- Cuando falla el patrón
#Cuatro niveles: 1.Principios, 2.Pautas, 3.Criterios, 4.Técnicas
#Debemos de crear hasta 6 métodos diferentes para realizar la escrita del archivo con los datos de la evaluación
###TECNICAS###
def datosTecnicasLista(tecnicas,reporte):
    for t in tecnicas:
        reporte.write('\t\t\tCódigo: ' + str(t["codigo"])+'-'+ str(t["titulo"])+'\n')
        reporte.write('\t\t\tCriticidad: ' + str(t["criticidad"])+'\n')
        reporte.write('\t\t\tObservación: ' + str(t["observacion"])+'\n')
        reporte.write('\t\t\tRecomendación: ' + str(t["recomendacion"])+'\n')
        reporte.write('\t\t\tNúmero de errores: ' + str(t["errores"])+'\n\n')

def datosTecnicasElemento(c,reporte):
    reporte.write('\t\t\tCódigo: ' + str(c["tecnicas"]["codigo"])+'-'+ str(c["tecnicas"]["titulo"])+'\n')
    reporte.write('\t\t\tCriticidad: ' + str(c["tecnicas"]["criticidad"])+'\n')
    reporte.write('\t\t\tObservación: ' + str(c["tecnicas"]["observacion"])+'\n')
    reporte.write('\t\t\tRecomendación: ' + str(c["tecnicas"]["recomendacion"])+'\n')
    reporte.write('\t\t\tNúmero de errores: ' + str(c["tecnicas"]["errores"])+'\n\n')

###CRITERIOS###
def datosCriteriosLista(criterios,reporte):
    for c in criterios:
        reporte.write('\t\tCriterio: ' + str(c["numero"])+'.'+ str(c["titulo"])+'\n')
        reporte.write('\t\tNivel: ' + str(c["nivel"])+'\n\n')
        try:
            tecnicas= c["tecnicas"]
            if isinstance(tecnicas, list):
                datosTecnicasLista(tecnicas,reporte)
            else:
                datosTecnicasElemento(c,reporte)

        except Exception as e:
            pass

def datosCriteriosElemento(p,reporte):
    reporte.write('\t\tCriterio: ' + str(p["criterios"]["numero"])+'.'+ str(p["criterios"]["titulo"])+'\n')
    reporte.write('\t\tNivel: ' + str(p["criterios"]["nivel"])+'\n\n')
    try:
        tecnicas= p["criterios"]["tecnicas"]
        if isinstance(tecnicas, list):
            datosTecnicasLista(tecnicas,reporte)
        else:
            datosTecnicasElemento(tecnicas,reporte)
    except Exception as e:
        pass

###PAUTAS###
def datosPautasLista(pautas,reporte):
    for p in pautas:
        reporte.write('\tPauta: ' + str(p["numero"])+'.'+ str(p["titulo"])+'\n')
        reporte.write('\tDescripcion: ' + str(p["descripcion"])+'\n\n')
        try:
            criterios=p["criterios"]
            if isinstance(criterios, list):
                datosCriteriosLista(criterios,reporte)
            else:
                datosCriteriosElemento(p,reporte)
        except Exception as e:
            pass

def datosPautasElemento(l,reporte):
    reporte.write('\tPauta: '+str(l["pautas"]["numero"])+'.'+str(l["pautas"]["titulo"])+'\n') 
    reporte.write('Descripcion: ' + str(l["pautas"]["descripcion"])+'\n\n')
    try:
        criterios=l["pautas"]["criterios"]
        if isinstance(criterios, list):
            datosCriteriosLista(criterios,reporte)
        else:
            datosCriteriosElemento(criterios,reporte)
    except Exception as e:
        pass

#Crear reporte
def crearReporte(principios,ruta_reporte,pagina_url,fecha_test):
    reporte = open(ruta_reporte, 'a')

    reporte.write(getCabeceraReporte(pagina_url,fecha_test))
    for p in principios:
        reporte.write('\nPrincipio: '+str(p["numero"])+'.'+str(p["titulo"])+'\n') 
        reporte.write('Descripcion: ' + str(p["descripcion"])+'\n\n')
        pautas=p["pautas"]
        if isinstance(pautas, list):
            datosPautasLista(pautas,reporte)
        else:
            datosPautasElemento(p,reporte)

    reporte.close()

#Método para ejecutar el proceso de evaluación
def ejecutarObservatorioUPS(pagina_id,pagina_url,herramienta,conexion,cursor):

    directorio = getDirectorioOSAW()

    fecha_test=getFecha()

    try:
        #Formato de la URL para utilizar la API de la herramienta
        url_request="http://observatorioweb.ups.edu.ec/oaw/srv/wcag/json/conformidad/?url="+pagina_url+"&key="+key

        #Tiempo de espera de 60 segundos
        r = requests.get(url=url_request,timeout=60)

        datos_json=json.loads(r.content.decode('utf-8'))

        #Número de problemas y advertencias por principio
        num_problemas_comprensible=datos_json["oaw"]["resultado"]["resumen"]["comprensible"]["errores"]
        num_advertencias_comprensible=datos_json["oaw"]["resultado"]["resumen"]["comprensible"]["advertencias"]

        num_problemas_operable=datos_json["oaw"]["resultado"]["resumen"]["operable"]["errores"]
        num_advertencias_operable=datos_json["oaw"]["resultado"]["resumen"]["operable"]["advertencias"]

        num_problemas_perceptible=datos_json["oaw"]["resultado"]["resumen"]["perceptible"]["errores"]
        num_advertencias_perceptible=datos_json["oaw"]["resultado"]["resumen"]["perceptible"]["advertencias"]

        num_problemas_robusto=datos_json["oaw"]["resultado"]["resumen"]["robusto"]["errores"]
        num_advertencias_robusto=datos_json["oaw"]["resultado"]["resumen"]["robusto"]["advertencias"]

        #Porcentajes de los principios
        porcentaje_comprensible=float(datos_json["oaw"]["resultado"]["resumen"]["totalComprensible"].replace("%",""))
        porcentaje_operable=float(datos_json["oaw"]["resultado"]["resumen"]["totalOperable"].replace("%",""))
        porcentaje_perceptible=float(datos_json["oaw"]["resultado"]["resumen"]["totalPerceptible"].replace("%",""))
        porcentaje_robusto=float(datos_json["oaw"]["resultado"]["resumen"]["totalRobusto"].replace("%",""))

        #Rutas para guardar el archivo y el acceso desde la BD
        ruta_reporte=getRutaReporte(directorio,herramienta,pagina_id,fecha_test)
        ruta_BD=getRutaReporte("",herramienta,pagina_id,fecha_test)

        #Obtenemos la lista de principios que es la única correcta 
        principios=datos_json["oaw"]["resultado"]["principios"]

        crearReporte(principios,ruta_reporte,pagina_url,fecha_test)
        
        #Guardamos los datos en la BD
        cursor = cursor.execute("insert into observatorios(pagina_id,porcentaje_comprensible,porcentaje_operable,porcentaje_perceptible,porcentaje_robusto,num_problemas_comprensible,num_problemas_operable,num_problemas_perceptible,num_problemas_robusto,num_advertencias_comprensible,num_advertencias_operable,num_advertencias_perceptible,num_advertencias_robusto,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),porcentaje_comprensible,porcentaje_operable,porcentaje_perceptible,porcentaje_robusto,num_problemas_comprensible,num_problemas_operable,num_problemas_perceptible,num_problemas_robusto,num_advertencias_comprensible,num_advertencias_operable,num_advertencias_perceptible,num_advertencias_robusto,ruta_BD,fecha_test,))
        
        desconexionBD(conexion)

    except Exception as e:
        errorLog(directorio,fecha_test,herramienta,pagina_id,e)


#Argumentos URL e ID de la página web
pagina_id=sys.argv[1]
pagina_url=sys.argv[2]

herramienta="observatorio"
key=OBSERVATORIO_KEY

#Conexión base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

ejecutarObservatorioUPS(pagina_id,pagina_url,herramienta,conexion,cursor)
desconexionBD(conexion)