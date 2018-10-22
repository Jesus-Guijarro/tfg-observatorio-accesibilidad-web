import json
import requests
import io


r = requests.get(url='http://observatorioweb.ups.edu.ec/oaw/srv/wcag/json/conformidad/?url=http://www.elmundo.es&key=b83e8400-5431-4b2b-8de8-4806a90fc418')

datos= json.loads(r.content.decode('utf-8'))

#print(datos["oaw"]["fecha"])


with io.open('archivo.txt', 'w') as f:
    f.write(json.dumps(datos))
