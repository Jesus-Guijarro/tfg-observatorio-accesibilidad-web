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
    datos=datos.replace('Success Criteria','\n\nCriterio de conformidad:')
    datos=datos.replace('Check','\n\n\tRevisar:')
    datos=datos.replace('Repair','\n\n\tReparar:')
    datos=datos.replace('Line','\n\n\t\tLínea:')
    datos=datos.replace('\t\t\t','')

    return datos

#Clase para validar elementos durante el modo headless 
class element_has_value(object):
 
  def __init__(self, locator, value):
    self.locator = locator
    self.value = value

  def __call__(self, driver):
    element = driver.find_element(*self.locator)   
    if self.value in element.get_attribute("value"):
        return element
    else:
        return False

#Obtenemos la url principal de un dominio.
# Necesario por si la web en cuestión cambia el protocolo de http a https
def getURL(dominio):
    
    cabecera="http://"
    request = requests.get(cabecera+dominio)
    url = request.url
    
    #Comprobamos si el protocolo es https
    if "https://" in url:
        cabecera = "https://"

    url = cabecera + dominio
    
    return url

#Devolver la fecha en formato: 'YYYY-MM-DD'
def getFecha():
    fecha_test = datetime.now().date()
    
    #Se devuelve en string
    fecha_test = str(fecha_test)

    return fecha_test

#Indicar ruta para guardar el archivo. 
#Para copias html y documentos de texto con los datos de las evaluaciones
def getDirectorio():
    #Directorio actual del archivo en ejecución
    directorio = os.path.dirname(os.path.abspath(__file__))
    directorio=directorio.replace("/Scraping","")
    directorio=directorio.replace("/storage/app","")

    return directorio

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

def getRutaComando(directorio,herramienta,pagina_web,pagina_id):

    ruta=directorio+"/storage/"+herramienta+".py " + str(pagina_web)+" "+ pagina_id

    return str(ruta)

#Método para escribir el archivo logs.txt el error encontrado
#   Tipo 1 -> Error provocado durante la ejecución de una herramienta
#   Tipo 3 -> Error provocado al no poder acceder a una web
#   Herramienta vacio en caso de ser tipo 3
def errorLog(directorio,tipo,fecha_test,herramienta,pagina_id):

    ruta_archivo_logs=directorio+"/storage/logs/log.txt"

    log = open(ruta_archivo_logs, 'a') 
    if tipo==1: 
        log.write('[01]\tError herramienta: "' + herramienta + '"\t\tFecha: "'+ fecha_test+'"\t\tPagina web: "' + pagina_id + '"\n')
    else:
        log.write('[03]\tError accesso página web: "' + pagina_id + '"\t\tFecha: "'+ fecha_test +'" \n')