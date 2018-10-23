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

    
    
    #Crear reporte
    ruta_reporte=directorio+"/storage/"+herramienta+"/"+pagina_id+"_"+str(fecha)+".txt"
    reporte = open(ruta_reporte, 'a')
    
    #Obtenemos la lista de principios que es la única correcta 
    lista=datos_json["oaw"]["resultado"]["principios"]

    #Los isinstance para comprar que el elemento es una lista
    #Los try para ignorar los casos en los que se no se encuentra cierto elemento- Cuando falla el patrón
    #Cuatro niveles: 1.Principios, 2.Pautas, 3.Criterios, 4.Ténicas
    reporte.write('Reporte de la página web: ' + pagina_url+ '\t\t'+"Fecha: "+ fecha+'\n')
    for l in lista:
        reporte.write('Principio: '+str(l["numero"])+'.'+str(l["titulo"])+'.\n') 
        reporte.write('Descripcion: ' + str(l["descripcion"])+'\n')
        pautas=l["pautas"]
        if isinstance(pautas, list):
            for p in pautas:
                reporte.write('\tPauta: ' + str(p["numero"])+'.'+ str(p["titulo"])+'\n')
                reporte.write('\tDescripcion: ' + str(p["descripcion"])+'\n')
                try:
                    criterios=p["criterios"]
                    if isinstance(criterios, list):
                        for c in criterios:
                            reporte.write('\t\tCriterio: ' + str(c["numero"])+'.'+ str(c["titulo"])+'\n')
                            reporte.write('\t\tNivel: ' + str(c["nivel"])+'\n')
                            try:
                                tecnicas= c["tecnicas"]
                                if isinstance(tecnicas, list):
                                    for t in tecnicas:
                                        reporte.write('\t\t\tCódigo: ' + str(t["codigo"])+'-'+ str(t["titulo"])+'\n')
                                        reporte.write('\t\t\tCriticidad: ' + str(t["criticidad"])+'.\n')
                                        reporte.write('\t\t\tObservación: ' + str(t["observacion"])+'.\n')
                                        reporte.write('\t\t\tRecomendación: ' + str(t["recomendacion"])+'.\n')
                                        print(t["codigo"])
                                        print(t["criticidad"])
                                        print(t["titulo"])
                                        print(t["errores"])
                                        print(t["observacion"])
                                        print(t["recomendacion"])
                                else:
                                    print(c["tecnicas"]["codigo"])
                                    print(c["tecnicas"]["criticidad"])
                                    print(c["tecnicas"]["titulo"])
                                    print(c["tecnicas"]["errores"])
                                    print(c["tecnicas"]["observacion"])
                                    print(c["tecnicas"]["recomendacion"])

                            except Exception as e:
                                pass
                    else:
                        print(p["criterios"]["numero"])
                        print(p["criterios"]["nivel"])
                        print(p["criterios"]["titulo"])
                        try:
                            tecnicas= p["criterios"]["tecnicas"]
                            if isinstance(tecnicas, list):
                                for t in tecnicas:
                                    pass
                                    print(t["codigo"])
                                    print(t["criticidad"])
                                    print(t["titulo"])
                                    print(t["errores"])
                                    print(t["observacion"])
                                    print(t["recomendacion"])
                        except Exception as e:
                            pass


                except Exception as e:
                    pass        
        else:
            print(l["pautas"]["numero"])
            print(l["pautas"]["descripcion"])
            print(l["pautas"]["titulo"])
            try:
                criterios=l["pautas"]["criterios"]
                if isinstance(criterios, list):
                    for c in criterios:
                        print(c["numero"])
                        print(c["nivel"])
                        print(c["titulo"])
                        try:
                            tecnicas= c["tecnicas"]
                            if isinstance(tecnicas, list):
                                for t in tecnicas:
                                    pass
                                    print(t["codigo"])
                                    print(t["criticidad"])
                                    print(t["titulo"])
                                    print(t["errores"])
                                    print(t["observacion"])
                                    print(t["recomendacion"])
                            else:
                                print(c["tecnicas"]["codigo"])
                                print(c["tecnicas"]["criticidad"])
                                print(c["tecnicas"]["titulo"])
                                print(c["tecnicas"]["errores"])
                                print(c["tecnicas"]["observacion"])
                                print(c["tecnicas"]["recomendacion"])

                        except Exception as e:
                            pass
                else:
                    print(p["criterios"]["numero"])
                    print(p["criterios"]["nivel"])
                    print(p["criterios"]["titulo"])
                    try:
                        tecnicas= p["criterios"]["tecnicas"]
                        if isinstance(tecnicas, list):
                            for t in tecnicas:
                                pass
                                print(t["codigo"])
                                print(t["criticidad"])
                                print(t["titulo"])
                                print(t["errores"])
                                print(t["observacion"])
                                print(t["recomendacion"])
                    except Exception as e:
                        pass
            except Exception as e:
                pass

            

except Exception as e:

    ruta_archivo_logs=directorio+"/storage/logs/log.txt"

    log = open(ruta_archivo_logs, 'a')  
    log.write("[3]Error herramienta: " + herramienta + "- Fecha: "+ fecha+"- Pagina web: " + pagina_url)

