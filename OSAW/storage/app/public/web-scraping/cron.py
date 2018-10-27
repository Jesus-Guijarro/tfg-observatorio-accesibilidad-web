import os,sys

from crontab import CronTab
from miscelaneo import *

#Argumentos

operacion=str(sys.argv[1]) # Crear -> 'C'; Actualizar -> 'A'; Eliminar -> 'E'
sitio_id=str(sys.argv[2])
periodicidad=str(sys.argv[3]) # Diaria -> 'D'; Semanal -> 'S';  Mensual -> 'M'
hora_dia=sys.argv[4] #Formato hh:mm
dia=sys.argv[5] #Día del mes o de la semana --- Semana: 0-Domingo, 6-Sábado

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
    directorio = getDirectorio()
    ruta_evaluacion=directorio+"/storage/web-scraping/evaluacion.py " + sitio_id

    #Comando y comentario asignado a la tarea
    comando="/usr/bin/python3 "+ ruta_evaluacion
    comentario="evaluar-sitio:"+ sitio_id

    #Creación de la tarea
    tarea= cron.new(command=comando, comment=comentario)  
    #En general es necesario indicar el minuto y la hora
    hora_dia=hora_dia.split(":")
    hora=hora_dia[0]
    minuto=hora_dia[1]

    dia = int(dia)

    tarea.minute.on(int(minuto))
    tarea.hour.on(int(hora))

    directorio=getDirectorio()

    if periodicidad == "S": #Semanal
        if dia<0 or dia>6:
            error="Día de la semana incorrecto. Valores posibles: 0 - 6"
            errorLog(directorio,2,getFecha(),"",sitio_id,error)
        else:
            tarea.dow.on(dia)
            cron.write() 

    elif periodicidad == "M": # Mensual
        if dia<1 or dia>31:
            error="Día del mes incorrecto. Valores posibles: 1 - 31"
            errorLog(directorio,2,getFecha(),"",sitio_id,error)
            
        else:
            tarea.day.on(dia)
            cron.write()
    else: #Diaria
        cron.write() 

#Método para ejecutar la operacion solicitada
def realizarOperacion(operacion):
    if operacion == "C": #Crear
        crear(sitio_id,periodicidad,hora_dia,dia)
    elif operacion == "A": # Actualizar
        eliminar(sitio_id)
        crear(sitio_id,periodicidad,hora_dia,dia)
    elif operacion == "E": #Eliminar
        eliminar(sitio_id)
    else:
        return False

realizarOperacion(operacion)