import json, requests, sys

from conexiones import *
from miscelaneo import *

#Argumentos URL e ID de la página web
pagina_url=sys.argv[1]
pagina_id=sys.argv[2]

herramienta="observatorio"
key="b83e8400-5431-4b2b-8de8-4806a90fc418"

#Conexión base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

#Ruta del directorio actual
directorio = getDirectorio()

fecha_test=getFecha()

try:
    #Formato de la URL para utilizar la API de la herramienta
    url_request="http://observatorioweb.ups.edu.ec/oaw/srv/wcag/json/conformidad/?url="+pagina_url+"&key="+key

    r = requests.get(url=url_request)

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
    
    #Crear reporte
    reporte = open(ruta_reporte, 'a')
    reporte.write(cabeceraReporte(pagina_url,fecha_test))

    #Obtenemos la lista de principios que es la única correcta 
    lista_principios=datos_json["oaw"]["resultado"]["principios"]

    #Los isinstance para comprar que el elemento es una lista
    #Los try para ignorar los casos en los que se no se encuentra cierto elemento- Cuando falla el patrón
    #Cuatro niveles: 1.Principios, 2.Pautas, 3.Criterios, 4.Ténicas
    reporte.write(cabeceraReporte(pagina_url,fecha_test))
    for l in lista_principios:
        reporte.write('\nPrincipio: '+str(l["numero"])+'.'+str(l["titulo"])+'\n') 
        reporte.write('Descripcion: ' + str(l["descripcion"])+'\n\n')
        pautas=l["pautas"]
        if isinstance(pautas, list):
            for p in pautas:
                reporte.write('\tPauta: ' + str(p["numero"])+'.'+ str(p["titulo"])+'\n')
                reporte.write('\tDescripcion: ' + str(p["descripcion"])+'\n\n')
                try:
                    criterios=p["criterios"]
                    if isinstance(criterios, list):
                        for c in criterios:
                            reporte.write('\t\tCriterio: ' + str(c["numero"])+'.'+ str(c["titulo"])+'\n')
                            reporte.write('\t\tNivel: ' + str(c["nivel"])+'\n\n')
                            try:
                                tecnicas= c["tecnicas"]
                                if isinstance(tecnicas, list):
                                    for t in tecnicas:
                                        reporte.write('\t\t\tCódigo: ' + str(t["codigo"])+'-'+ str(t["titulo"])+'\n')
                                        reporte.write('\t\t\tCriticidad: ' + str(t["criticidad"])+'\n')
                                        reporte.write('\t\t\tObservación: ' + str(t["observacion"])+'\n')
                                        reporte.write('\t\t\tRecomendación: ' + str(t["recomendacion"])+'\n')
                                        reporte.write('\t\t\tNúmero de errores: ' + str(t["errores"])+'\n\n')
                                else:
                                    reporte.write('\t\t\tCódigo: ' + str(c["tecnicas"]["codigo"])+'-'+ str(c["tecnicas"]["titulo"])+'\n')
                                    reporte.write('\t\t\tCriticidad: ' + str(c["tecnicas"]["criticidad"])+'\n')
                                    reporte.write('\t\t\tObservación: ' + str(c["tecnicas"]["observacion"])+'\n')
                                    reporte.write('\t\t\tRecomendación: ' + str(c["tecnicas"]["recomendacion"])+'\n')
                                    reporte.write('\t\t\tNúmero de errores: ' + str(c["tecnicas"]["errores"])+'\n\n')
                            except Exception as e:
                                pass
                    else:
                        reporte.write('\t\tCriterio: ' + str(p["criterios"]["numero"])+'.'+ str(p["criterios"]["titulo"])+'\n')
                        reporte.write('\t\tNivel: ' + str(p["criterios"]["nivel"])+'\n\n')
                        try:
                            tecnicas= p["criterios"]["tecnicas"]
                            if isinstance(tecnicas, list):
                                for t in tecnicas:
                                    reporte.write('\t\t\tCódigo: ' + str(t["codigo"])+'-'+ str(t["titulo"])+'\n')
                                    reporte.write('\t\t\tCriticidad: ' + str(t["criticidad"])+'\n')
                                    reporte.write('\t\t\tObservación: ' + str(t["observacion"])+'\n')
                                    reporte.write('\t\t\tRecomendación: ' + str(t["recomendacion"])+'\n')
                                    reporte.write('\t\t\tNúmero de errores: ' + str(t["errores"])+'\n\n')
                            else:
                                reporte.write('\t\t\tCódigo: ' + str(c["tecnicas"]["codigo"])+'-'+ str(c["tecnicas"]["titulo"])+'\n')
                                reporte.write('\t\t\tCriticidad: ' + str(c["tecnicas"]["criticidad"])+'\n')
                                reporte.write('\t\t\tObservación: ' + str(c["tecnicas"]["observacion"])+'\n')
                                reporte.write('\t\t\tRecomendación: ' + str(c["tecnicas"]["recomendacion"])+'\n')
                                reporte.write('\t\t\tNúmero de errores: ' + str(c["tecnicas"]["errores"])+'\n\n')
                        except Exception as e:
                            pass
                except Exception as e:
                    pass        
        else:
            reporte.write('\tPauta: '+str(l["pautas"]["numero"])+'.'+str(l["pautas"]["titulo"])+'\n') 
            reporte.write('Descripcion: ' + str(l["pautas"]["descripcion"])+'\n\n')
            try:
                criterios=l["pautas"]["criterios"]
                if isinstance(criterios, list):
                    for c in criterios:
                        reporte.write('\t\tCriterio: ' + str(c["numero"])+'.'+ str(c["titulo"])+'\n')
                        reporte.write('\t\tNivel: ' + str(c["nivel"])+'\n\n')
                        try:
                            tecnicas= c["tecnicas"]
                            if isinstance(tecnicas, list):
                                for t in tecnicas:
                                    reporte.write('\t\t\tCódigo: ' + str(t["codigo"])+'-'+ str(t["titulo"])+'\n')
                                    reporte.write('\t\t\tCriticidad: ' + str(t["criticidad"])+'\n')
                                    reporte.write('\t\t\tObservación: ' + str(t["observacion"])+'\n')
                                    reporte.write('\t\t\tRecomendación: ' + str(t["recomendacion"])+'\n')
                                    reporte.write('\t\t\tNúmero de errores: ' + str(t["errores"])+'\n\n')
                            else:
                                reporte.write('\t\t\tCódigo: ' + str(c["tecnicas"]["codigo"])+'-'+ str(c["tecnicas"]["titulo"])+'\n')
                                reporte.write('\t\t\tCriticidad: ' + str(c["tecnicas"]["criticidad"])+'\n')
                                reporte.write('\t\t\tObservación: ' + str(c["tecnicas"]["observacion"])+'\n')
                                reporte.write('\t\t\tRecomendación: ' + str(c["tecnicas"]["recomendacion"])+'\n')
                                reporte.write('\t\t\tNúmero de errores: ' + str(c["tecnicas"]["errores"])+'\n\n')
                        except Exception as e:
                            pass
                else:
                    reporte.write('\t\tCriterio: ' + str(p["criterios"]["numero"])+'.'+ str(p["criterios"]["titulo"])+'\n')
                    reporte.write('\t\tNivel: ' + str(p["criterios"]["nivel"])+'\n\n')
                    try:
                        tecnicas= p["criterios"]["tecnicas"]
                        if isinstance(tecnicas, list):
                            for t in tecnicas:
                                reporte.write('\t\t\tCódigo: ' + str(t["codigo"])+'-'+ str(t["titulo"])+'\n')
                                reporte.write('\t\t\tCriticidad: ' + str(t["criticidad"])+'\n')
                                reporte.write('\t\t\tObservación: ' + str(t["observacion"])+'\n')
                                reporte.write('\t\t\tRecomendación: ' + str(t["recomendacion"])+'\n')
                                reporte.write('\t\t\tNúmero de errores: ' + str(t["errores"])+'\n\n')
                        else:
                            reporte.write('\t\t\tCódigo: ' + str(c["tecnicas"]["codigo"])+'-'+ str(c["tecnicas"]["titulo"])+'\n')
                            reporte.write('\t\t\tCriticidad: ' + str(c["tecnicas"]["criticidad"])+'\n')
                            reporte.write('\t\t\tObservación: ' + str(c["tecnicas"]["observacion"])+'\n')
                            reporte.write('\t\t\tRecomendación: ' + str(c["tecnicas"]["recomendacion"])+'\n')
                            reporte.write('\t\t\tNúmero de errores: ' + str(c["tecnicas"]["errores"])+'\n\n')
                    except Exception as e:
                        pass
            except Exception as e:
                pass
    
    #Guardamos los datos en la BD
    cursor = cursor.execute("insert into observatorios(pagina_id,porcentaje_comprensible,porcentaje_operable,porcentaje_perceptible,porcentaje_robusto,num_problemas_comprensible,num_problemas_operable,num_problemas_perceptible,num_problemas_robusto,num_advertencias_comprensible,num_advertencias_operable,num_advertencias_perceptible,num_advertencias_robusto,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),porcentaje_comprensible,porcentaje_operable,porcentaje_perceptible,porcentaje_robusto,num_problemas_comprensible,num_problemas_operable,num_problemas_perceptible,num_problemas_robusto,num_advertencias_comprensible,num_advertencias_operable,num_advertencias_perceptible,num_advertencias_robusto,ruta_BD,fecha_test,))
    desconexionBD(conexion,cursor)
    

except Exception as e:
    errorLog(directorio,1,getFecha(),herramienta,pagina_id,e)

