from time import time

def calcularTiemposAcceso(herramienta,tiempo,operacion):
    ruta_archivo_tiempos="/home/jesus/TFG/Webscraping/tiempos/"+herramienta+".txt"

    tiempos = open(ruta_archivo_tiempos, 'a')

    tiempos.write("Operación: " + operacion + '\tTiempo: ' + str(tiempo))

    tiempos.close()

t1=time()

tiempo=time()-t1

calcularTiemposAcceso("accessmonitor",tiempo,"acceso")