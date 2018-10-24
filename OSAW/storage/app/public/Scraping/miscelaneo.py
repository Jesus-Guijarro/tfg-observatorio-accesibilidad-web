import os

from selenium import webdriver
from datetime import datetime


#Activar el modo headless
def modoHeadless():

    opciones = webdriver.ChromeOptions()

    opciones.binary_location = '/usr/bin/google-chrome'
    opciones.add_argument('headless')

    driver = webdriver.Chrome(chrome_options=opciones)

    return driver

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

#Devolver la fecha en formato: 'YYYY-MM-DD'
def getFecha(st):
    fecha_test = datetime.now().date()
    #Se devuelve en string si se pide
    if st:
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
def errorLog(directorio,tipo,fecha_test,herramienta,pagina_url):

    ruta_archivo_logs=directorio+"/storage/logs/log.txt"

    log = open(ruta_archivo_logs, 'a') 
    if tipo==1: 
        log.write("[01]\tError herramienta: " + herramienta + "\t\tFecha: "+ fecha_test+"\t\tPagina web: " + pagina_url + ".\n")
    else:
        log.write("[03]\tError accesso página web: " + pagina_url + "\t\tFecha: "+ fecha_test + "\n")