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

print(datos_json["oaw"]["fecha"])




