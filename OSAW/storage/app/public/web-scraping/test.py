from miscelaneo import *
from conexiones import *

#Conexion base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]


def copiarArchivoAntiguo(ruta_reporte,ruta_reporte_antiguo,fecha_test,fecha_test_antiguo):
    r1 = open(ruta_reporte_antiguo, 'r')
    r2 = open(ruta_reporte, 'w')
    for linea in r1:
        r2.write(linea.replace(str(fecha_test_antiguo), fecha_test))
    r1.close()
    r2.close()

def copiarDatosAntiguos(herramienta_eval,herramienta,pagina_id,cursor):
    
    if herramienta_eval:
        fecha_test=getFecha()
        directorio = getDirectorio()

        #accessmonitor
        if herramienta == "accessmonitor":
            cursor.execute("select puntuacion,num_problemas_a, num_problemas_aa,num_problemas_aaa,num_advertencias_a,num_advertencias_aa,num_advertencias_aaa,datos_problemas,fecha_test from accessmonitors where pagina_id = %s order by id desc limit 1", (pagina_id,))
            
            evaluacion = cursor.fetchone()

            puntuacion=evaluacion.__getitem__(0)
            num_problemas_a=evaluacion.__getitem__(1)
            num_problemas_aa=evaluacion.__getitem__(2)
            num_problemas_aaa=evaluacion.__getitem__(3)
            num_advertencias_a=evaluacion.__getitem__(4)
            num_advertencias_aa=evaluacion.__getitem__(5)
            num_advertencias_aaa=evaluacion.__getitem__(6)
            ruta_reporte_antiguo=evaluacion.__getitem__(7)
            fecha_test_antiguo=evaluacion.__getitem__(8)

            ruta_BD=getRutaReporte("",herramienta,pagina_id,fecha_test)

            ruta_reporte_antiguo=getRutaReporte(directorio,herramienta,pagina_id,fecha_test_antiguo)
            ruta_reporte=getRutaReporte(directorio,herramienta,pagina_id,fecha_test)
            
            #Copiar archivo datos del archivo antiguo cambiando sólo la fecha del análisis
            copiarArchivoAntiguo(ruta_reporte,ruta_reporte_antiguo,fecha_test,fecha_test_antiguo)

            cursor = cursor.execute("insert into accessmonitors(pagina_id,puntuacion,num_problemas_a, num_problemas_aa,num_problemas_aaa,num_advertencias_a,num_advertencias_aa,num_advertencias_aaa,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),puntuacion,num_problemas_a, num_problemas_aa,num_problemas_aaa,num_advertencias_a,num_advertencias_aa,num_advertencias_aaa,ruta_BD,fecha_test,))
            desconexionBD(conexion,cursor)


        #achecker
        elif herramienta == "achecker":
            pass

        #eiiichecker
        elif herramienta == "eiiichecker":
            pass

        #observatorio
        elif herramienta == "observatorio":
            pass

        #vamola
        elif herramienta == "vamola":
            pass

        #wave
        elif herramienta == "wave":
            pass



copiarDatosAntiguos(True,"accessmonitor",1,cursor)