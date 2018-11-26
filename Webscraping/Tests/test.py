import sys, os

directorio_import = os.path.dirname(os.path.abspath(__file__))
directorio_import=directorio_import.replace('/tests','')
sys.path.append(directorio_import)

from herramienta import getFecha


reporte = open("/home/jesus/TFG/WEBSCRAPING/ejemplo.txt", 'w')
reporte.write(getFecha())

reporte.close()




