#EIII Page Checker
import sys

from conexiones import *
from miscelaneo import *

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

#Argumentos
pagina_url=sys.argv[1]
pagina_id=sys.argv[2]

herramienta="eiiichecker"

#Conexion base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

#Ruta del directorio actual
directorio = getDirectorio()

fecha_test=getFecha()

try:
    #Activamos el modo headless
    driver=modoHeadless()

    #Accedemos a la web de la herramienta de evaluacion
    driver.get('http://checkers.eiii.eu/en/pagecheck/')

    #Pausa explicita de 30 segundos
    #Se pausa hasta que se encuentra el elemento
    wait = WebDriverWait(driver, 30) 

    #Esperamos hasta que accedemos a la web de la herramienta
    #En caso negativo se cancela el análisis y se cierra el driver
    try:
        elem =wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "#logo > h1")))
    except:
        driver.quit()
        raise Exception('No se ha podido acceder a la herramienta')

    #Comprobamos que aparece la advertencia inicial
    if EC.element_to_be_clickable((By.CSS_SELECTOR, "#premission_question > p > button")):
        accept =  driver.find_element_by_css_selector("#premission_question > p > button")
        accept.click()

    #Elemento input en el que se introduce la url de la pagina a evaluar
    enlace =  driver.find_element_by_css_selector("#id_url")
    enlace.clear()

    #Indicamos la url
    enlace.send_keys(pagina_url)

    #Se selecciona el botón de "check" para obtener el análisis 
    check =  driver.find_element_by_css_selector('#page_checker > div > input[type="submit"]')
    check.click()

    #Pausa de máximo 2 minuto
    wait = WebDriverWait(driver, 120)
    #Se espera hasta que se haya evaluado y ofrecido el resultado
    try:
        elem =wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "#resultSummary > form > ul > li:nth-child(1) > label > strong")))
    except:
        driver.quit()
        raise Exception('No se ha podido realizar la evaluación')


    puntuacion = float(driver.find_element_by_css_selector('#resultSummary > form > ul > li:nth-child(4) > div > span > span').text)
    print(puntuacion)

    num_problemas =  int(driver.find_element_by_css_selector('#ul-appliedtests > li:nth-child(2) > strong > span').text.replace('Fail: ',''))
    print(num_problemas)

    num_aciertos =  int(driver.find_element_by_css_selector('#ul-appliedtests > li:nth-child(4) > strong > span').text.replace('Pass: ',''))
    print(num_aciertos)

    

    #Inicializamos las variables para hacer el recuento de problemas segun nivel
    num_problemas_a = 0
    num_problemas_aa = 0

    #Rutas para guardar el archivo y el acceso desde la BD
    ruta_reporte=getRutaReporte(directorio,herramienta,pagina_id,fecha_test)
    ruta_BD=getRutaReporte("",herramienta,pagina_id,fecha_test)

    #Crear reporte
    reporte = open(ruta_reporte, 'a')
    reporte.write('Reporte de la página web: ' + pagina_url+ '\t\t'+"Fecha: "+ fecha_test+'\n')

    #Datos problemas y calculo de número de problemas según nivel
    def datoProblema(frase,problema, nivel):
        try:
            problema=int(driver.find_element_by_id(problema))
            reporte.write(frase+'\t Veces encontrado: '+ problema+'\n')
            if nivel=="A":
                num_problemas_a = num_problemas_a + problema
            elif nivel =="AA":
                num_problemas_aa = num_problemas_aa + problema
        except Exception as e:
            pass
        
    datoProblema("Uso de <alt> en elementos <img> [1.1.1]","icon_alt-on-img_rstFail", "A")
    datoProblema("Uso de color [1.4.1]","icon_use-color_rstFail", "A")
    datoProblema("Uso de controladores de eventos específicos del dispositivo señalador únicamente [2.1.1]","icon_pointing-device-events_rstFail", "A")
    datoProblema("Se proporcionan títulos descriptivos para las páginas web [2.4.2]","icon_title-not-descriptive_rstFail", "A")
    datoProblema("Se Proporcionan enlaces para navegar a páginas web relacionadas [2.4.5]","icon_links-webpages_rstFail", "AA")
    datoProblema("Se roporcionan encabezados descriptivos [2.4.6]","icon_descriptive-headings_rstFail", "AA")
    datoProblema("Lenguaje principal de la página indicado [3.1.1]","icon_language-determine_rstFail", "A")
    datoProblema("Idioma de las partes [3.1.2]","icon_language-attributes-page_rstFail", "AA")
    datoProblema("Enviar formularios sin enviar botones [3.2.2]","icon_forms-without-buttons_rstFail", "A")
    datoProblema("Se proporciona un botón de enviar para iniciar un cambio de contexto [3.2.2]","icon_submit-buttons_rstFail", "AA")
    datoProblema("Etiquetar grupos de elementos de formulario [3.3.2]","icon_h71-sturcture_rstFail", "A")
    datoProblema("Elementos de referencia [4.1.1]","icon_referencing-element_rstFail", "A")
    datoProblema("Definir identificadores para elementos [4.1.1]","icon_id-unique-value_rstFail", "A")
    datoProblema("Usar <title> para los elementos frame e iframe [4.1.2]","icon_title-frame-iframe_rstFail", "A")
    datoProblema("Nombre accesible para imágenes con enlace [4.1.2]","icon_null-alt-image_rstFail", "A")
    datoProblema("Se utilizan los controles y enlaces de formulario HTML [4.1.2]","icon_form-controls-links_rstFail", "A")
    datoProblema("Se proporciona el nombre del rol para <div> / <span> con el controlador de eventos [4.1.2]","icon_script-ui-control_rstFail", "A")
    

    cursor = cursor.execute("insert into eiiicheckers(pagina_id,puntuacion,num_problemas, num_aciertos,num_problemas_a,num_problemas_aa,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),puntuacion,num_problemas, num_aciertos,num_problemas_a,num_problemas_aa,ruta_BD,fecha_test,))
    desconexionBD(conexion,cursor)

except Exception as e:
    errorLog(directorio,1,getFecha(),herramienta,pagina_id)


driver.quit()