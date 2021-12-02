import sys, os

from database import conexionBD,desconexionBD
from crontab import CronTab

#Método para cambiar el estado de automatización de un sitio
def actualizarTarea(operacion,sitio_id,conexion,cursor):
    #Si se crea, la automatiación se pone a cierto
    if operacion == "C":
        cursor.execute("update sitios set automatizado=%s where id=%s",(True,sitio_id,))
        conexion.commit()
    #En caso de que se elimine, la automatizacion del sitio se pone a falso
    else:
        cursor.execute("update sitios set automatizado=%s where id=%s",(False,sitio_id,))
        conexion.commit()

#Método para crear una tarea
def crearTarea(sitio_id,periodicidad,hora,dia,cursor):

    directorio = os.path.dirname(os.path.abspath(__file__))
    ruta_evaluacion=directorio+"/main.py " + str(sitio_id)

    #Comando y comentario asignado a la tarea
    comando="/usr/bin/python3 "+ ruta_evaluacion
    comentario="evaluar-sitio:"+ str(sitio_id)

    #Creación de la tarea
    tarea= cron.new(command=comando, comment=comentario)  
    #En general es necesario indicar el minuto y la hora
    hora=hora.split(":")
    minuto=hora[1]
    hora=hora[0]

    dia = int(dia)

    tarea.minute.on(int(minuto))
    tarea.hour.on(int(hora))

    mensaje_error="No se ha podido crear la tarea para el sitio: "+ str(sitio_id)

    if periodicidad == "Semanal": #Semanal
        #Verificacion de los dias disponibles de la semana
        if dia<0 or dia>6:
            error=mensaje_error+"- ERROR: Día de la semana incorrecto. Valores posibles: 0 - 6"
            raise Exception(error)
        else:
            tarea.dow.on(dia)
            cron.write() 

    elif periodicidad == "Mensual": # Mensual
        #Comprobacion de los dias del mes posibles
        if dia<1 or dia>31:
            error=mensaje_error+"- ERROR: Día del mes incorrecto. Valores posibles: 1 - 31"
            raise Exception(error)
        else:
            tarea.day.on(dia)
            cron.write()
    else: #Diario
        cron.write() 

    actualizarTarea("C",sitio_id,conexion,cursor)

#Método para eliminar una tarea
def eliminarTarea(sitio_id,conexion,cursor):
    comentario="evaluar-sitio:"+str(sitio_id)
    tareas=cron.find_comment(comentario)  

    for tarea in tareas:
        cron.remove(tarea)  

    cron.write()

    actualizarTarea("E",sitio_id,conexion,cursor)

#Método para ejecutar la operacion solicitada
def ejecutarOperacion(operacion,periodicidad,hora,dia,sitio_id,conexion,cursor):
    if operacion == "C": #Crear
        crearTarea(sitio_id,periodicidad,hora,dia,cursor)
    elif operacion == "A": # Actualizar
        eliminarTarea(sitio_id,conexion,cursor)
        crearTarea(sitio_id,periodicidad,hora,dia,cursor)
    elif operacion == "E": #Eliminar
        eliminarTarea(sitio_id,conexion,cursor)

#Configuar la tarea de un sitio
#Argumentos necesarios: 1. operacion a realizar y 2. identificador del sitio a gestionar
def asignarTareaSitio(sitio_id,operacion,conexion,cursor):
    
    cursor.execute("select periodicidad,hora,dia,automatizado from sitios where id = %s", (sitio_id,))
    
    sitio = cursor.fetchone()

    periodicidad=sitio.__getitem__(0) # Diaria; Semanal; Mensual
    hora=str(sitio.__getitem__(1)) #Formato hh:mm
    dia=int(sitio.__getitem__(2)) #Día del mes o de la semana --- Semana: 0-Domingo, 6-Sábado
    automatizado=bool(sitio.__getitem__(3))
    
    ejecutarOperacion(operacion,periodicidad,hora,dia,sitio_id,conexion,cursor)

#Asignar una tarea a cada sitio
def asignarTareasSitios(conexion,cursor):

    cursor.execute("select id,periodicidad,hora,dia,automatizado from sitios")
    sitios = cursor.fetchall()

    for sitio in sitios:
        sitio_id=sitio.__getitem__(0)
        periodicidad=sitio.__getitem__(1) # Diaria; Semanal; Mensual
        hora=str(sitio.__getitem__(2)) #Formato hh:mm
        dia=int(sitio.__getitem__(3)) #Día del mes o de la semana --- Semana: 0-Domingo, 6-Sábado
        automatizado=bool(sitio.__getitem__(4))

        # Si ya está automatizado se realiza la operación de actualización, en caso contrario se crea
        if automatizado: 
            ejecutarOperacion("A",periodicidad,hora,dia,sitio_id,conexion,cursor)
        else:
            ejecutarOperacion("C",periodicidad,hora,dia,sitio_id,conexion,cursor)


def ejecutarCrontab(argumentos,conexion,cursor):

    #Se elige la operación a realizar para una única tarea
    if len(argumentos) == 3:
        sitio_id=str(argumentos[1])
        operacion=str(argumentos[2]) # Crear -> 'C'; Actualizar -> 'A'; Eliminar -> 'E'

        asignarTareaSitio(sitio_id,operacion,conexion,cursor)

    #Se asigna una tarea a cada sitio de la base de datos
    elif len(argumentos) == 1:
        asignarTareasSitios(conexion,cursor)

#Conexion base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

#Inicializamos crontab
cron = CronTab(user='jesus')

argumentos=sys.argv
ejecutarCrontab(argumentos,conexion,cursor)
desconexionBD(conexion)