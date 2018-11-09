import os, requests

from selenium import webdriver
from datetime import datetime

#Activar el modo headless
def modoHeadless():

    opciones = webdriver.ChromeOptions()

    opciones.binary_location = '/usr/bin/google-chrome'
    opciones.add_argument('headless')

    driver = webdriver.Chrome(chrome_options=opciones)

    return driver


#Transformar datos de problemas para guardarlos en archivos de texto
def transformarDatos(datos):
    #No son simples saltos de linea , son lineas con espacios en blanco, tabulados, etc
    datos=datos.replace('  ','')
    datos=datos.replace('\n','')
    datos=datos.replace('        ','\n\n')
    datos=datos.replace('Success Criteria','\n\nCRITERIO DE CONFORMIDAD:')
    datos=datos.replace('Check','\n\n\tREVISAR:')
    datos=datos.replace('Repair','\n\n\tREPARAR:')
    datos=datos.replace('Line','\n\n\t\tLINEA:')
    datos=datos.replace('Column','COLUMNA:')
    datos=datos.replace('\t\t\t','')

    return datos

#Herramientas: Achecker y Vamolà
#Escribir y obtener los datos de los problemas
def datosProblemas(tipo_problema,reporte,driver):
    try:
        problemas=driver.find_element_by_id(tipo_problema)

        datos=str(problemas.get_attribute('textContent'))
        datos=transformarDatos(datos)
        
        if tipo_problema == "AC_errors":
            reporte.write("PROBLEMAS CONOCIDOS\n")
            reporte.write(datos + "\n\n ------------------------------------------------------ \n\n")
        else:
            reporte.write("PROBLEMAS POTENCIALES\n")
            reporte.write(datos + "\n")
        
        return datos

    except Exception as e:
        return False
#Función para obtener el número de problemas segun el nivel
def getNumProblemas(datos,nivel):
    if datos:
        return int(datos.count(nivel))
    return 0

#Devolver la fecha en formato: 'YYYY-MM-DD'
def getFecha():
    fecha_test = datetime.now().date()
    
    #Se devuelve en string
    fecha_test = str(fecha_test)

    return fecha_test

#Obtener directorio ../OSAW/public 
#Para copias html y documentos de texto con los datos de las evaluaciones
def getDirectorio():
    #Directorio actual del archivo en ejecución
    directorio = os.path.dirname(os.path.abspath(__file__))
    directorio=directorio.replace("/web-scraping","")
    directorio=directorio.replace("/storage/app","")

    return directorio

def getCabeceraReporte(pagina_url,fecha_test):
    cabecera='REPORTE PÁGINA WEB: ' + pagina_url+ '\t\t'+"FECHA EVALUACIÓN: "+ fecha_test+'\n\n'
    return cabecera

#Ruta para guardar rutas de reportes
def getRutaReporte(directorio,herramienta,pagina_id,fecha_test):
    #Directorio vacio si es para la BD
    ruta = directorio+"/storage/"+herramienta+"/"+str(pagina_id)+"_"+str(fecha_test)+".txt"
    
    return ruta

#Ruta para guardar rutas de copias HTML
def getRutaCopiaHTML(directorio,pagina_id, nuevo):
    #Directorio vacio si es para la BD
    ruta=directorio+"/storage/paginas/"+str(pagina_id)+nuevo+".html"

    return ruta

#Obtenemos la ruta donde se encuentra la herramienta
def getRutaHerramienta(directorio,herramienta):

    ruta=directorio+"/storage/web-scraping/"+herramienta+".py"

    return ruta

#Método para escribir el archivo logs.txt el error encontrado
#   Tipo 1 -> Error provocado durante la ejecución de una herramienta
#   Tipo 2 -> Error provocado al no poder crear una tarea con cron.py
#   Tipo 3 -> Error provocado al no poder acceder a una web
#   Herramienta vacio en caso de ser tipo 2 ó 3
def errorLog(directorio,tipo,fecha_test,herramienta,identificador,error):

    ruta_archivo_logs=directorio+"/storage/logs/log_"+fecha_test+".txt"

    #Para tener más información de la fecha obtenemos también los datos de hora, minutos y segundos
    fecha_absoluta= str(datetime.now())

    log = open(ruta_archivo_logs, 'a')
     
    if tipo==1: 
        log.write('[01]\tERROR HERRAMIENTA: "' + herramienta + '"\t\tFECHA: "'+ fecha_absoluta+'"\t\tPAGINA WEB: "' + identificador +'"\t\tDESCRIPCION: "'+repr(error)+ '"\n')
    elif tipo==2:
        log.write('[02]\tERROR ACCESSO PAGINA WEB: "' + identificador + '"\t\tFECHA: "'+ fecha_absoluta +'" \n')
    
    log.close()


#Métodos para copiar archivos y datos antiguos de los reportes de evaluación
def copiarArchivoAntiguo(ruta_reporte,ruta_reporte_antiguo,fecha_test,fecha_test_antiguo):
    r1 = open(ruta_reporte_antiguo, 'r')
    r2 = open(ruta_reporte, 'w')
    for linea in r1:
        r2.write(linea.replace(str(fecha_test_antiguo), fecha_test))
    r1.close()
    r2.close()

#Método para ejecutar la evaluación de la herramienta en caso de no encontrar un análisis anterior
def ejecutarHerramienta(directorio,herramienta,pagina_id,pagina_url):

    ruta_herramienta=getRutaHerramienta(directorio,herramienta)

    try:
        subprocess.run(["/usr/bin/python3",ruta_herramienta,str(pagina_id),str(pagina_url)])
    except Exception as e:
        pass

#Método para realizar el copiado de los datos de un test anterior.
def copiarDatosAntiguos(seleccionada,herramienta,pagina_url,pagina_id,cursor):
    if seleccionada:
        fecha_test=getFecha()
        directorio = getDirectorio()

        #accessmonitor
        if herramienta == "accessmonitor":

            #Se comprueba que hay un reporte anterior
            cursor.execute("select count(*) from accessmonitors where pagina_id = %s order by id desc limit 1", (pagina_id,))
            
            resultado = cursor.fetchone()
            cantidad=resultado.__getitem__(0)
            
            if cantidad>0:

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
            else:
                ejecutarHerramienta(directorio,herramienta,pagina_id,pagina_url)

        #achecker
        elif herramienta == "achecker":

            #Se comprueba que hay un reporte anterior
            cursor.execute("select count(*) from acheckers where pagina_id = %s order by id desc limit 1", (pagina_id,))
            
            resultado = cursor.fetchone()
            cantidad=resultado.__getitem__(0)
            
            if cantidad>0:
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
            
            else:
                ejecutarHerramienta(directorio,herramienta,pagina_id,pagina_url)

        #eiiichecker
        elif herramienta == "eiiichecker":

            #Se comprueba que hay un reporte anterior
            cursor.execute("select count(*) from eiiicheckers where pagina_id = %s order by id desc limit 1", (pagina_id,))
            
            resultado = cursor.fetchone()
            cantidad=resultado.__getitem__(0)
            
            if cantidad>0:
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
            
            else:
                ejecutarHerramienta(directorio,herramienta,pagina_id,pagina_url)

        #observatorio
        elif herramienta == "observatorio":
            #Se comprueba que hay un reporte anterior
            cursor.execute("select count(*) from observatorios where pagina_id = %s order by id desc limit 1", (pagina_id,))
            
            resultado = cursor.fetchone()
            cantidad=resultado.__getitem__(0)
            
            if cantidad>0:
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
            
            else:
                ejecutarHerramienta(directorio,herramienta,pagina_id,pagina_url)

        #vamola
        elif herramienta == "vamola":
            #Se comprueba que hay un reporte anterior
            cursor.execute("select count(*) from vamolas where pagina_id = %s order by id desc limit 1", (pagina_id,))
            
            resultado = cursor.fetchone()
            cantidad=resultado.__getitem__(0)
            
            if cantidad>0:
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
            
            else:
                ejecutarHerramienta(directorio,herramienta,pagina_id,pagina_url)

        #wave
        elif herramienta == "wave":
            #Se comprueba que hay un reporte anterior
            cursor.execute("select count(*) from waves where pagina_id = %s order by id desc limit 1", (pagina_id,))
            
            resultado = cursor.fetchone()
            cantidad=resultado.__getitem__(0)
            
            if cantidad>0:
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
            
            else:
                ejecutarHerramienta(directorio,herramienta,pagina_id,pagina_url)
                    