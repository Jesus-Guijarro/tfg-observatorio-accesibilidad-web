import os

from tool import getDirectoryOSAW
directorio = os.path.dirname(os.path.abspath(__file__))
'''
reporte = open("/home/jesus/TFG/Webscraping/ejemplo.txt", 'w')
reporte.write(str(directorio))
'''
herramienta="A"
ruta_herramienta= str(os.path.dirname(os.path.abspath(__file__)))
ruta_herramienta= ruta_herramienta +"/Tools/"+ str(herramienta) + ".py"


print(os.path.dirname(os.path.abspath(__file__)))