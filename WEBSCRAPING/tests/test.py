import sys

sys.path.append("/home/jesus/TFG/WEBSCRAPING")

from test_p import getFecha


reporte = open("/home/jesus/TFG/WEBSCRAPING/ejemplo.txt", 'w')
reporte.write(getFecha())

reporte.close()




