import sys

from conexiones import *
from miscelaneo import *
from crontab import CronTab

#Argumentos
operacion=str(sys.argv[1]) # Crear -> 'C'; Actualizar -> 'A'; Eliminar -> 'E'
sitio_id=str(sys.argv[2])


#Conexion base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

cursor.execute("select periodicidad,hora,dia from sitios where id = %s", (sitio_id,))
sitio = cursor.fetchone()

periodicidad=sitio.__getitem__(0) # Diario; Semanal; Mensual
hora=str(sitio.__getitem__(1)) #Formato hh:mm
dia=int(sitio.__getitem__(2)) #Día del mes o de la semana --- Semana: 0-Domingo, 6-Sábado

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
def crear(sitio_id,periodicidad,hora,dia):

    #Rutas
    directorio = getDirectorio()
    ruta_evaluacion=directorio+"/storage/web-scraping/evaluacion.py " + sitio_id

    #Comando y comentario asignado a la tarea
    comando="/usr/bin/python3 "+ ruta_evaluacion
    comentario="evaluar-sitio:"+ sitio_id

    #Creación de la tarea
    tarea= cron.new(command=comando, comment=comentario)  
    #En general es necesario indicar el minuto y la hora
    hora=hora.split(":")

    minuto=hora[1]
    hora=hora[0]

    dia = int(dia)

    tarea.minute.on(int(minuto))
    tarea.hour.on(int(hora))

    directorio=getDirectorio()

    if periodicidad == "Semanal": #Semanal
        if dia<0 or dia>6:
            error="Día de la semana incorrecto. Valores posibles: 0 - 6"
            errorLog(directorio,2,getFecha(),"",sitio_id,error)
        else:
            tarea.dow.on(dia)
            cron.write() 

    elif periodicidad == "Mensual": # Mensual
        if dia<1 or dia>31:
            error="Día del mes incorrecto. Valores posibles: 1 - 31"
            errorLog(directorio,2,getFecha(),"",sitio_id,error)
            
        else:
            tarea.day.on(dia)
            cron.write()
    else: #Diario
        cron.write() 

#Método para ejecutar la operacion solicitada
def realizarOperacion(operacion,periodicidad,hora,dia):
    if operacion == "C": #Crear
        crear(sitio_id,periodicidad,hora,dia)
    elif operacion == "A": # Actualizar
        eliminar(sitio_id)
        crear(sitio_id,periodicidad,hora,dia)
    elif operacion == "E": #Eliminar
        eliminar(sitio_id)
    else:
        return False

realizarOperacion(operacion,periodicidad,hora,dia)

desconexionBD(conexion,cursor)