import os

def calcularTiemposAcceso(herramienta,tiempo,operacion):
    ruta_archivo_tiempos="/home/jesus/TFG/Webscraping/tiempos/"+herramienta+"_"+operacion+".txt"

    tiempos = open(ruta_archivo_tiempos, 'a')

    tiempos.write(str(tiempo) + '\n')

    tiempos.close()
