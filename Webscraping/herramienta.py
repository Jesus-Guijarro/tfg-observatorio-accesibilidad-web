import os, requests, subprocess,mysql.connector, logging

from selenium import webdriver
from datetime import datetime

#Método para llamar a las herramientas
def ejecutarHerramienta(herramienta,pagina_id,pagina_url):
    #Ruta: ../Herramientas/ToolX.py
    ruta_herramienta= str(os.path.dirname(os.path.abspath(__file__)))
    ruta_herramienta= ruta_herramienta +"/Herramientas/"+ str(herramienta) + ".py"

    try:
        subprocess.run(["/usr/bin/python3",ruta_herramienta,str(pagina_id),str(pagina_url)])
    except Exception as e:
        pass

#Activar el modo headless
def driverHeadlessBrowser():

    opciones = webdriver.ChromeOptions()

    opciones.binary_location = '/usr/bin/google-chrome'
    opciones.add_argument('headless')

    driver = webdriver.Chrome(chrome_options=opciones)

    return driver

#Transformar datos de problemas para guardarlos en archivos de texto
def procesarDatos(datos):
    #No son simples saltos de linea , son lineas con espacios en blanco, tabulados, etc
    datos=datos.replace('  ','')
    datos=datos.replace('\n','')
    datos=datos.replace('        ','\n\n')
    datos=datos.replace('Success Criteria','\n\nCRITERIO DE CONFORMIDAD:')
    datos=datos.replace('Check','\n\n\tREVISAR:')
    datos=datos.replace('Repair','\n\n\tREPARAR')
    datos=datos.replace('Line','\n\n\t\tLINEA:')
    datos=datos.replace('Column','COLUMNA:')
    datos=datos.replace('\t\t\t','')
    datos=datos.replace('Congratulations! No known problems.', 'Ningún problema conocido encontrado.')
    datos=datos.replace('Congratulations! No potential problems.', 'Ningún problema potencial encontrado.')

    return datos

#Herramientas: Achecker y Vamolà
#Escribir y obtener los datos de los problemas
def getDatosProblemas(tipo_problema,reporte,driver):
    try:
        problemas=driver.find_element_by_id(tipo_problema)

        datos=str(problemas.get_attribute('textContent'))
        datos=procesarDatos(datos)
        
        if tipo_problema == "AC_errors":
            reporte.write("-PROBLEMAS CONOCIDOS-\n")
            reporte.write(datos + "\n\n\n\n")
        else:
            reporte.write("-PROBLEMAS POTENCIALES-\n")
            reporte.write(datos + "\n")
        
        return datos

    except Exception as e:
        return False

#Función para obtener el número de problemas segun el nivel
def getNumeroProblemas(datos,nivel):
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
def getDirectorioOSAW():
    #Directorio actual del archivo en ejecución
    directorio = os.path.dirname(os.path.abspath(__file__))
    #En caso de que se ejecute desde la carpeta Herramientas:
    if directorio.find("/Webscraping/Herramientas")!= (-1):
        directorio=directorio.replace("/Webscraping/Herramientas","/OSAW/public")
    else:
        directorio=directorio.replace("/Webscraping","/OSAW/public")

    #Se le añade la carpeta storage al final para acceder en Laravel directamente
    directorio = directorio+"/storage"

    return directorio

#Ruta para guardar rutas de reportes
def getRutaReporte(directorio,herramienta,pagina_id,fecha_test):
    #Directorio vacio si es para la BD
    ruta = directorio+"/"+herramienta+"/"+str(pagina_id)+"_"+str(fecha_test)+".txt"
    
    return ruta

#Ruta para guardar rutas de copias HTML
def getRutaCopiaHTML(directorio,pagina_id, nuevo):
    #El argumento directorio está vacio si es para la BD
    ruta=directorio+"/paginas/"+str(pagina_id)+nuevo+".html"

    return ruta

#Método para escribir error producidos durante los análisis de las herramientas
def errorLog(directorio,fecha_test,herramienta,identificador,error):

    ruta_archivo_logs=directorio+"/logs/herramientas/log_herramientas_"+fecha_test+".log"

    
    logging.basicConfig(filename=ruta_archivo_logs,level=logging.ERROR,format='%(asctime)s - %(levelname)s - %(name)s\n\t%(message)s', datefmt='%m/%d/%Y %I:%M:%S %p')
    logger = logging.getLogger("EVALUACION_HERRAMIENTA")
    
    logger.error('HERRAMIENTA: "'+herramienta + '"\n\tPAGINA WEB: ' + str(identificador) +'\n\tINFORMACION: "'+repr(error)+ '"\n')

#Cabecera de los documentos con la información de los problemas encontrados
def getCabeceraReporte(pagina_url,fecha_test):
    cabecera='REPORTE PÁGINA WEB: ' + pagina_url+ '\n'+"FECHA EVALUACIÓN: "+ fecha_test+'\n\n'
    return cabecera

#Métodos para copiar archivos y datos antiguos de los reportes de evaluación
def copiarDatosArchivoAntiguo(ruta_reporte,ruta_reporte_antiguo,fecha_test,fecha_test_antiguo):
    reporte_antiguo = open(ruta_reporte_antiguo, 'r')
    reporte = open(ruta_reporte, 'w')
    for linea in reporte_antiguo:
        reporte.write(linea.replace(str(fecha_test_antiguo), fecha_test))
    reporte_antiguo.close()
    reporte.close()


#Método para realizar el copiado de los datos de un test anterior.
def copiarDatosAntiguos(herramienta,pagina_url,pagina_id,cursor):

    fecha_test=getFecha()
    directorio = getDirectorioOSAW()

    #accessmonitor
    if herramienta == "accessmonitor":

        #Se comprueba que hay un reporte anterior, ya que es posible que se haya podido guardar la copia HTML pero no llegado a analizarla por error de la herramienta
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
            copiarDatosArchivoAntiguo(ruta_reporte,ruta_reporte_antiguo,fecha_test,fecha_test_antiguo)

            cursor = cursor.execute("insert into accessmonitors(pagina_id,puntuacion,num_problemas_a, num_problemas_aa,num_problemas_aaa,num_advertencias_a,num_advertencias_aa,num_advertencias_aaa,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),puntuacion,num_problemas_a, num_problemas_aa,num_problemas_aaa,num_advertencias_a,num_advertencias_aa,num_advertencias_aaa,ruta_BD,fecha_test,))
        else:
            ejecutarHerramienta(herramienta,pagina_id,pagina_url)

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
            copiarDatosArchivoAntiguo(ruta_reporte,ruta_reporte_antiguo,fecha_test,fecha_test_antiguo)

            cursor = cursor.execute("insert into acheckers(pagina_id,num_problemas_conocidos, num_problemas_potenciales,num_problemas_conocidos_a,num_problemas_conocidos_aa,num_problemas_conocidos_aaa,num_problemas_potenciales_a,num_problemas_potenciales_aa,num_problemas_potenciales_aaa,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),num_problemas_conocidos, num_problemas_potenciales,num_problemas_conocidos_a,num_problemas_conocidos_aa,num_problemas_conocidos_aaa,num_problemas_potenciales_a,num_problemas_potenciales_aa,num_problemas_potenciales_aaa,ruta_BD,fecha_test,))
        
        else:
            ejecutarHerramienta(herramienta,pagina_id,pagina_url)

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
            copiarDatosArchivoAntiguo(ruta_reporte,ruta_reporte_antiguo,fecha_test,fecha_test_antiguo)

            cursor = cursor.execute("insert into eiiicheckers(pagina_id,puntuacion,num_problemas, num_aciertos,num_problemas_a,num_problemas_aa,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),puntuacion,num_problemas, num_aciertos,num_problemas_a,num_problemas_aa,ruta_BD,fecha_test,))
        
        else:
            ejecutarHerramienta(herramienta,pagina_id,pagina_url)

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
            copiarDatosArchivoAntiguo(ruta_reporte,ruta_reporte_antiguo,fecha_test,fecha_test_antiguo)

            cursor = cursor.execute("insert into observatorios(pagina_id,porcentaje_comprensible,porcentaje_operable,porcentaje_perceptible,porcentaje_robusto,num_problemas_comprensible,num_problemas_operable,num_problemas_perceptible,num_problemas_robusto,num_advertencias_comprensible,num_advertencias_operable,num_advertencias_perceptible,num_advertencias_robusto,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),porcentaje_comprensible,porcentaje_operable,porcentaje_perceptible,porcentaje_robusto,num_problemas_comprensible,num_problemas_operable,num_problemas_perceptible,num_problemas_robusto,num_advertencias_comprensible,num_advertencias_operable,num_advertencias_perceptible,num_advertencias_robusto,ruta_BD,fecha_test,))
        
        else:
            ejecutarHerramienta(herramienta,pagina_id,pagina_url)

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
            copiarDatosArchivoAntiguo(ruta_reporte,ruta_reporte_antiguo,fecha_test,fecha_test_antiguo)

            cursor = cursor.execute("insert into vamolas(pagina_id,num_problemas_conocidos, num_problemas_potenciales,num_problemas_conocidos_a,num_problemas_conocidos_aa,num_problemas_conocidos_aaa,num_problemas_potenciales_a,num_problemas_potenciales_aa,num_problemas_potenciales_aaa,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),num_problemas_conocidos, num_problemas_potenciales,num_problemas_conocidos_a,num_problemas_conocidos_aa,num_problemas_conocidos_aaa,num_problemas_potenciales_a,num_problemas_potenciales_aa,num_problemas_potenciales_aaa,ruta_BD,fecha_test,))
        
        else:
            ejecutarHerramienta(herramienta,pagina_id,pagina_url)

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
            copiarDatosArchivoAntiguo(ruta_reporte,ruta_reporte_antiguo,fecha_test,fecha_test_antiguo)

            cursor=cursor.execute("insert into waves(pagina_id,num_problemas, num_advertencias, num_caracteristicas, num_elem_ARIA, num_problemas_contraste,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),num_problemas, num_advertencias, num_caracteristicas, num_elem_ARIA, num_problemas_contraste,ruta_BD,fecha_test,))
        
        else:
            ejecutarHerramienta(herramienta,pagina_id,pagina_url)
                    