from miscelaneo import *

import os, requests

url="https://www.agenciatributaria.es/AEAT.internet/Inicio/_otros_/Mapa_web/Mapa_web.shtml"

request = requests.get(url)
tipo = request.headers.get('content-type')

#Formato: text/html;charset=utf-8
tipo = tipo.lower()
tipo = tipo.replace(' ','')

if tipo in "text/hml":
    print(tipo)






