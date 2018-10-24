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

#Devolver la fecha en formato: 'YYYY-MM-DD'
def getFecha():
    fecha = datetime.now().date()
    return fecha

#Indicar ruta para guardar el archivo. 
#Para copias html y documentos de texto con los datos de las evaluaciones
def setRutaArchivo(carpeta):
    directorio = os.path.dirname(os.path.abspath(__file__))

    directorio=directorio.replace("/Scraping/","")
    directorio=directorio.replace("/storage/app","")

    ruta = directorio+"/storage/"+carpeta+"/"

    return ruta

#Ruta para guardar rutas de reportes en la BD y ser accesibles desde Laravel
def setRutaReporte(herramienta,pagina_id,fecha):
    ruta = "/storage/"+herramienta+"/"+str(pagina_id)+"_"+str(fecha)+".txt"
    
    return ruta

#Ruta para guardar rutas de copias HTML en la BD y ser accesibles desde Laravel
def setRutaCopiaHTML(pagina_id, nuevo):
    ruta="/storage/paginas/"+str(pagina_id)+nuevo+".html"

    return ruta
