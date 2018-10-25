from miscelaneo import *

import os, requests

url="http://www.mjusticia.gob.es/cs/Satellite/Portal/eu/inicio"

request = requests.get(url)
tipo = request.headers.get('content-type')

#Formato: text/html;charset=utf-8
tipo = tipo.lower()
tipo = tipo.replace(' ','')
print(tipo)
if "text/html" in tipo:
    print(tipo)






