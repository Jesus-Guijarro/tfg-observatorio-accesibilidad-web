import os,sys

from crontab import CronTab
from datetime import datetime  

#Argumentos

operacion=str(sys.argv[1]) # crear = c; modificar = m; eliminar = e
sitio_id=sys.argv[2]
herramienta=sys.argv[3]
periodicidad=int(sys.argv[4]) # Diaria : 1; Semanal : 2; Quincenal : 3; Mensual : 4
hora_dia=sys.argv[5]
dia=sys.argv[6] #Día del mes o de la semana - Valor 0 en caso de no necesitar

#Inicializamos crontab
cron = CronTab(user='jesus')

#Método para eliminar una tarea
def eliminar(sitio_id,herramienta):
    tareas=cron.find_comment(str(sitio_id)+"-"+str(herramienta))  

    for tarea in tareas:
        cron.remove(tarea)  

    cron.write()

#Método para crear una tarea
def crear(sitio_id,herramienta,periodicidad,hora_dia,dia):

    #Rutas
    directorio = str(os.getcwd())
    directorio=directorio.replace("/Scraping","")
    directorio=directorio.replace("/storage/app","")

    #ruta_evaluar=directorio+"/storage/Scraping/" + evaluar.py + " " +sitio_id
    ruta_evaluar=directorio+"/storage/Scraping/test.py"

    #Comando y comentario asignado a la tarea
    comando="/usr/bin/python3 "+ ruta_evaluar
    comentario=str(sitio_id)+"-"+str(herramienta)

    tarea= cron.new(command=comando, comment=comentario)  

    #En general es necesario indicar el minuto y la hora

    hora_dia=hora_dia.split(":")
    hora=hora_dia[0]
    minuto=hora_dia[1]

    tarea.minute.on(int(minuto))
    tarea.hour.on(int(hora))

    if periodicidad == 2: #Semanal
        tarea.dow.on(dia)
    elif periodicidad == 3: #Quincenal
        tarea.day.every(14)
    elif periodicidad == 4: # Mensual
        tarea.day.on(dia)

    cron.write() 

#Método para ejecutar la operacion solicitada
def realizarOperacion(operacion):
    if operacion == "c":
        crear(sitio_id,herramienta,periodicidad,hora_dia,dia)
    elif operacion == "m":
        eliminar(sitio_id,herramienta)
        crear(sitio_id,herramienta,periodicidad,hora_dia,dia)
    else: 
        eliminar(sitio_id,herramienta)

realizarOperacion(operacion)