from miscelaneo import *
from conexiones import *



def datosAntiguos(herramienta_eval,herramienta,pagina_id):

    fecha_test=getFecha()

    directorio=getDirectorio()

    ruta_reporte1=getRutaReporte(directorio,herramienta,pagina_id,fecha_test)
    ruta_reporte2=getRutaReporte(directorio,herramienta,pagina_id,"2018-10-30")
    

    ruta_BD=getRutaReporte("",herramienta,pagina_id,fecha_test)

    columnas_herramientas={
        "accessmonitor":"puntuacion,num_problemas_a, num_problemas_aa,num_problemas_aaa,num_advertencias_a,num_advertencias_aa,num_advertencias_aaa",
        "achecker":"num_problemas_conocidos, num_problemas_potenciales,num_problemas_conocidos_a,num_problemas_conocidos_aa,num_problemas_conocidos_aaa,num_problemas_potenciales_a,num_problemas_potenciales_aa,num_problemas_potenciales_aaa",
        "eiiichecker":"num_problemas, num_aciertos,num_problemas_a,num_problemas_aa",
        "observatorio":"porcentaje_comprensible,porcentaje_operable,porcentaje_perceptible,porcentaje_robusto,num_problemas_comprensible,num_problemas_operable,num_problemas_perceptible,num_problemas_robusto,num_advertencias_comprensible,num_advertencias_operable,num_advertencias_perceptible,num_advertencias_robusto",
        "vamola":"num_problemas_conocidos, num_problemas_potenciales,num_problemas_conocidos_a,num_problemas_conocidos_aa,num_problemas_conocidos_aaa,num_problemas_potenciales_a,num_problemas_potenciales_aa,num_problemas_potenciales_aaa",
        "wave":"num_problemas, num_advertencias, num_caracteristicas, num_elem_ARIA, num_problemas_contraste"
    }

    f1 = open(ruta_reporte1, 'r')
    f2 = open(ruta_reporte2, 'w')
    for line in f1:
        f2.write(line.replace("2018-10-27", "2018-10-30"))
    f1.close()
    f2.close()
    


parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

datosAntiguos(1,"achecker",1)