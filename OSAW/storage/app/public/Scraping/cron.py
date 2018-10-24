import os,sys

from crontab import CronTab
from datetime import datetime  

#Argumentos

operacion=str(sys.argv[1]) # Crear -> C; Actualizar -> A; Eliminar -> E
sitio_id=str(sys.argv[2])
periodicidad=str(sys.argv[3]) # Diaria -> D; Semanal -> S;  Mensual -> M
hora_dia=sys.argv[4]
dia=sys.argv[5] #Día del mes o de la semana

#Inicializamos crontab
cron = CronTab(user='jesus')

#Método para eliminar una tarea
def eliminar(sitio_id):
    comentario="evaluar-sitio:"+sitio_id
    tareas=cron.find_comment(comentario)  

    for tarea in tareas:
        cron.remove(tarea)  

    cron.write()

#Método para crear una tarea
def crear(sitio_id,periodicidad,hora_dia,dia):

    #Rutas
    directorio = os.path.dirname(os.path.abspath(__file__))
    directorio=directorio.replace("/Scraping","")
    directorio=directorio.replace("/storage/app","")

    #ruta_evaluador=directorio+"/storage/Scraping/test.py " + sitio_id
    ruta_evaluador=directorio+"/storage/Scraping/evaluador.py " + sitio_id

    #Comando y comentario asignado a la tarea
    comando="/usr/bin/python3 "+ ruta_evaluador
    comentario="evaluar-sitio:"+ sitio_id

    tarea= cron.new(command=comando, comment=comentario)  

    #En general es necesario indicar el minuto y la hora

    hora_dia=hora_dia.split(":")
    hora=hora_dia[0]
    minuto=hora_dia[1]

    tarea.minute.on(int(minuto))
    tarea.hour.on(int(hora))

    if periodicidad == "S": #Semanal
        tarea.dow.on(dia)
    elif periodicidad == "M": # Mensual
        tarea.day.on(dia)

    cron.write() 

#Método para ejecutar la operacion solicitada
def realizarOperacion(operacion):
    if operacion == "C":
        crear(sitio_id,periodicidad,hora_dia,dia)
    elif operacion == "U":
        eliminar(sitio_id)
        crear(sitio_id,periodicidad,hora_dia,dia)
    elif operacion == "E":
        eliminar(sitio_id)
    else:
        #Error en log.txt
        return False

realizarOperacion(operacion)