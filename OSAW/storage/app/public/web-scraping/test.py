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
            cursor.execute("select num_problemas_conocidos, num_problemas_potenciales,num_problemas_conocidos_a,num_problemas_conocidos_aa,num_problemas_conocidos_aaa,num_problemas_potenciales_a,num_problemas_potenciales_aa,num_problemas_potenciales_aaa,datos_problemas,fecha_test from acheckers where pagina_id = %s order by id desc limit 1", (pagina_id,))
            
            evaluacion = cursor.fetchone()

            num_problemas_conocidos=evaluacion.__getitem__(0)
            num_problemas_potenciales=evaluacion.__getitem__(1)
            num_problemas_conocidos_a=evaluacion.__getitem__(2)
            num_problemas_conocidos_aa=evaluacion.__getitem__(3)
            num_problemas_conocidos_aaa=evaluacion.__getitem__(4)
            num_problemas_potenciales_a=evaluacion.__getitem__(5)
            num_problemas_potenciales_aa=evaluacion.__getitem__(6)
            num_problemas_potenciales_aaa=evaluacion.__getitem__(7)
            ruta_reporte_antiguo=evaluacion.__getitem__(8)
            fecha_test_antiguo=evaluacion.__getitem__(9)

            ruta_BD=getRutaReporte("",herramienta,pagina_id,fecha_test)

            ruta_reporte_antiguo=getRutaReporte(directorio,herramienta,pagina_id,fecha_test_antiguo)
            ruta_reporte=getRutaReporte(directorio,herramienta,pagina_id,fecha_test)
            
            #Copiar archivo datos del archivo antiguo cambiando sólo la fecha del análisis
            copiarArchivoAntiguo(ruta_reporte,ruta_reporte_antiguo,fecha_test,fecha_test_antiguo)

            cursor = cursor.execute("insert into acheckers(pagina_id,num_problemas_conocidos, num_problemas_potenciales,num_problemas_conocidos_a,num_problemas_conocidos_aa,num_problemas_conocidos_aaa,num_problemas_potenciales_a,num_problemas_potenciales_aa,num_problemas_potenciales_aaa,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),num_problemas_conocidos, num_problemas_potenciales,num_problemas_conocidos_a,num_problemas_conocidos_aa,num_problemas_conocidos_aaa,num_problemas_potenciales_a,num_problemas_potenciales_aa,num_problemas_potenciales_aaa,ruta_BD,fecha_test,))
            desconexionBD(conexion,cursor)

        #eiiichecker
        elif herramienta == "eiiichecker":
            cursor.execute("select puntuacion,num_problemas, num_aciertos,num_problemas_a,num_problemas_aa,datos_problemas,fecha_test from eiiicheckers where pagina_id = %s order by id desc limit 1", (pagina_id,))
            
            evaluacion = cursor.fetchone()

            puntuacion=evaluacion.__getitem__(0)
            num_problemas=evaluacion.__getitem__(1)
            num_aciertos=evaluacion.__getitem__(2)
            num_problemas_a=evaluacion.__getitem__(3)
            num_problemas_aa=evaluacion.__getitem__(4)
            ruta_reporte_antiguo=evaluacion.__getitem__(5)
            fecha_test_antiguo=evaluacion.__getitem__(6)

            ruta_BD=getRutaReporte("",herramienta,pagina_id,fecha_test)

            ruta_reporte_antiguo=getRutaReporte(directorio,herramienta,pagina_id,fecha_test_antiguo)
            ruta_reporte=getRutaReporte(directorio,herramienta,pagina_id,fecha_test)
            
            #Copiar archivo datos del archivo antiguo cambiando sólo la fecha del análisis
            copiarArchivoAntiguo(ruta_reporte,ruta_reporte_antiguo,fecha_test,fecha_test_antiguo)

            cursor = cursor.execute("insert into eiiicheckers(pagina_id,puntuacion,num_problemas, num_aciertos,num_problemas_a,num_problemas_aa,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),puntuacion,num_problemas, num_aciertos,num_problemas_a,num_problemas_aa,ruta_BD,fecha_test,))
            desconexionBD(conexion,cursor)

        #observatorio
        elif herramienta == "observatorio":
            cursor.execute("select porcentaje_comprensible,porcentaje_operable,porcentaje_perceptible,porcentaje_robusto,num_problemas_comprensible,num_problemas_operable,num_problemas_perceptible,num_problemas_robusto,num_advertencias_comprensible,num_advertencias_operable,num_advertencias_perceptible,num_advertencias_robusto,datos_problemas,fecha_test from observatorios where pagina_id = %s order by id desc limit 1", (pagina_id,))
            
            evaluacion = cursor.fetchone()

            porcentaje_comprensible=evaluacion.__getitem__(0)
            porcentaje_operable=evaluacion.__getitem__(1)
            porcentaje_perceptible=evaluacion.__getitem__(2)
            porcentaje_robusto=evaluacion.__getitem__(3)
            num_problemas_comprensible=evaluacion.__getitem__(4)
            num_problemas_operable=evaluacion.__getitem__(5)
            num_problemas_perceptible=evaluacion.__getitem__(6)
            num_problemas_robusto=evaluacion.__getitem__(7)
            num_advertencias_comprensible=evaluacion.__getitem__(8)
            num_advertencias_operable=evaluacion.__getitem__(9)
            num_advertencias_perceptible=evaluacion.__getitem__(10)
            num_advertencias_robusto=evaluacion.__getitem__(11)
            ruta_reporte_antiguo=evaluacion.__getitem__(12)
            fecha_test_antiguo=evaluacion.__getitem__(13)

            ruta_BD=getRutaReporte("",herramienta,pagina_id,fecha_test)

            ruta_reporte_antiguo=getRutaReporte(directorio,herramienta,pagina_id,fecha_test_antiguo)
            ruta_reporte=getRutaReporte(directorio,herramienta,pagina_id,fecha_test)
            
            #Copiar archivo datos del archivo antiguo cambiando sólo la fecha del análisis
            copiarArchivoAntiguo(ruta_reporte,ruta_reporte_antiguo,fecha_test,fecha_test_antiguo)

            cursor = cursor.execute("insert into observatorios(pagina_id,porcentaje_comprensible,porcentaje_operable,porcentaje_perceptible,porcentaje_robusto,num_problemas_comprensible,num_problemas_operable,num_problemas_perceptible,num_problemas_robusto,num_advertencias_comprensible,num_advertencias_operable,num_advertencias_perceptible,num_advertencias_robusto,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),porcentaje_comprensible,porcentaje_operable,porcentaje_perceptible,porcentaje_robusto,num_problemas_comprensible,num_problemas_operable,num_problemas_perceptible,num_problemas_robusto,num_advertencias_comprensible,num_advertencias_operable,num_advertencias_perceptible,num_advertencias_robusto,ruta_BD,fecha_test,))
            desconexionBD(conexion,cursor)

        #vamola
        elif herramienta == "vamola":
            cursor.execute("select num_problemas_conocidos, num_problemas_potenciales,num_problemas_conocidos_a,num_problemas_conocidos_aa,num_problemas_conocidos_aaa,num_problemas_potenciales_a,num_problemas_potenciales_aa,num_problemas_potenciales_aaa,datos_problemas,fecha_test from vamolas where pagina_id = %s order by id desc limit 1", (pagina_id,))
            
            evaluacion = cursor.fetchone()

            num_problemas_conocidos=evaluacion.__getitem__(0)
            num_problemas_potenciales=evaluacion.__getitem__(1)
            num_problemas_conocidos_a=evaluacion.__getitem__(2)
            num_problemas_conocidos_aa=evaluacion.__getitem__(3)
            num_problemas_conocidos_aaa=evaluacion.__getitem__(4)
            num_problemas_potenciales_a=evaluacion.__getitem__(5)
            num_problemas_potenciales_aa=evaluacion.__getitem__(6)
            num_problemas_potenciales_aaa=evaluacion.__getitem__(7)
            ruta_reporte_antiguo=evaluacion.__getitem__(8)
            fecha_test_antiguo=evaluacion.__getitem__(9)

            ruta_BD=getRutaReporte("",herramienta,pagina_id,fecha_test)

            ruta_reporte_antiguo=getRutaReporte(directorio,herramienta,pagina_id,fecha_test_antiguo)
            ruta_reporte=getRutaReporte(directorio,herramienta,pagina_id,fecha_test)
            
            #Copiar archivo datos del archivo antiguo cambiando sólo la fecha del análisis
            copiarArchivoAntiguo(ruta_reporte,ruta_reporte_antiguo,fecha_test,fecha_test_antiguo)

            cursor = cursor.execute("insert into vamolas(pagina_id,num_problemas_conocidos, num_problemas_potenciales,num_problemas_conocidos_a,num_problemas_conocidos_aa,num_problemas_conocidos_aaa,num_problemas_potenciales_a,num_problemas_potenciales_aa,num_problemas_potenciales_aaa,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),num_problemas_conocidos, num_problemas_potenciales,num_problemas_conocidos_a,num_problemas_conocidos_aa,num_problemas_conocidos_aaa,num_problemas_potenciales_a,num_problemas_potenciales_aa,num_problemas_potenciales_aaa,ruta_BD,fecha_test,))
            desconexionBD(conexion,cursor)

        #wave
        elif herramienta == "wave":
            cursor.execute("select num_problemas, num_advertencias, num_caracteristicas, num_elem_ARIA, num_problemas_contraste,datos_problemas,fecha_test from waves where pagina_id = %s order by id desc limit 1", (pagina_id,))
            
            evaluacion = cursor.fetchone()

            num_problemas=evaluacion.__getitem__(0)
            num_advertencias=evaluacion.__getitem__(1)
            num_caracteristicas=evaluacion.__getitem__(2)
            num_elem_ARIA=evaluacion.__getitem__(3)
            num_problemas_contraste=evaluacion.__getitem__(4)
            ruta_reporte_antiguo=evaluacion.__getitem__(5)
            fecha_test_antiguo=evaluacion.__getitem__(6)

            ruta_BD=getRutaReporte("",herramienta,pagina_id,fecha_test)

            ruta_reporte_antiguo=getRutaReporte(directorio,herramienta,pagina_id,fecha_test_antiguo)
            ruta_reporte=getRutaReporte(directorio,herramienta,pagina_id,fecha_test)
            
            #Copiar archivo datos del archivo antiguo cambiando sólo la fecha del análisis
            copiarArchivoAntiguo(ruta_reporte,ruta_reporte_antiguo,fecha_test,fecha_test_antiguo)

            cursor=cursor.execute("insert into waves(pagina_id,num_problemas, num_advertencias, num_caracteristicas, num_elem_ARIA, num_problemas_contraste,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),num_problemas, num_advertencias, num_caracteristicas, num_elem_ARIA, num_problemas_contraste,ruta_BD,fecha_test,))
            desconexionBD(conexion,cursor)



copiarDatosAntiguos(True,"achecker",1,cursor)