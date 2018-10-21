import json
import requests
import io


r = requests.get(url='http://axe.wtkollen.tingtun.no/export-jsonld/pagecheck2.0/?url=http://accesibilidadweb.dlsi.ua.es/')

datos= json.loads(r.content.decode('utf-8'))

#print(datos["status"]["success"])

with io.open('archivo.txt', 'w') as f:
    f.write(json.dumps(datos))