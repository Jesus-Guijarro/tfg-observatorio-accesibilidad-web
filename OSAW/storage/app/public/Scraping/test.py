from datetime import datetime
import os, json

'''
myFile = open('/home/jesus/Documents/file.txt', 'a')  
myFile.write(str(datetime.now().date()))  
'''
directorio = os.path.dirname(os.path.abspath(__file__))

directorio=directorio.replace("/Scraping","")
directorio=directorio.replace("/storage/app","")

ruta_archivo=directorio+"/storage/Scraping/ejemplo.txt"


file= open(ruta_archivo, "r")
content=file.read()

datos = str(content)

datos_json=json.loads(datos)

lista=datos_json["oaw"]["resultado"]["principios"]


for l in lista:
    #print(l["numero"])
    #print(l["titulo"])
    #print(l["descripcion"])
    pautas=l["pautas"]
    if isinstance(pautas, list):
        for p in pautas:
            #print(p["numero"])
            #print(p["descripcion"])
            #print(p["titulo"])
            try:
                criterios=p["criterios"]
                if isinstance(criterios, list):
                    for c in criterios:
                        try:
                            tecnicas= c["tecnicas"]
                            if isinstance(tecnicas, list):
                                for t in tecnicas:
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
        #print(l["pautas"]["numero"])
        #print(l["pautas"]["descripcion"])
        #print(l["pautas"]["titulo"])
        criterios=p["criterios"]
    


'''
d = datos_json["categories"]["error"]["items"]

valores = d.values()
claves = d.keys()
'''



