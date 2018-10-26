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
    num_problemas =  int(driver.find_element_by_css_selector('#ul-appliedtests > li:nth-child(2) > strong > span').text.replace('Fail: ',''))
    num_aciertos =  int(driver.find_element_by_css_selector('#ul-appliedtests > li:nth-child(4) > strong > span').text.replace('Pass: ',''))
    
    #Inicializamos las variables para hacer el recuento de problemas segun nivel
    num_problemas_a = 0
    num_problemas_aa = 0

    #Rutas para guardar el archivo y el acceso desde la BD
    ruta_reporte=getRutaReporte(directorio,herramienta,pagina_id,fecha_test)
    ruta_BD=getRutaReporte("",herramienta,pagina_id,fecha_test)

    #Crear reporte
    reporte = open(ruta_reporte, 'a')
    reporte.write(cabeceraReporte(pagina_url,fecha_test))

    #Datos problemas y calculo de número de problemas según nivel
    def datosProblema(frase,problema, nivel,driver):
        try:
            problema=int(driver.find_element_by_id(problema))
            reporte.write(frase+'\t\t VECES ENCONTRADO: '+ problema+'\n')
            if nivel=="A":
                num_problemas_a = num_problemas_a + problema
            elif nivel =="AA":
                num_problemas_aa = num_problemas_aa + problema
        except Exception as e:
            pass
        
    datosProblema("CRITERIO DE CONFORMIDAD: 1.1.1: Contenido no textual       TÉCNICA H37: Uso de <alt> en elementos <img>","icon_alt-on-img_rstFail", "A",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 1.4.1: Uso del color ","icon_use-color_rstFail", "A",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 2.1.1 Teclado         FALLO F54: Fallo del Criterio de Conformidad 2.1.1 debido a que solo se utilizan controladores de eventos específicos del dispositivo señalador (incluido el gesto) para una función","icon_pointing-device-events_rstFail", "A",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 2.4.2: Titulado de páginas       FALLO F25: Fallo del Criterio de Conformidad 2.4.2 debido al título de una página web que no identifica los contenidos","icon_title-not-descriptive_rstFail", "A",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 2.4.5: Múltiples vías       TÉCNICA G125: Proporcionar enlaces para navegar a páginas web relacionadas","icon_links-webpages_rstFail", "AA",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 2.4.6: Encabezados y etiquetas       TÉCNICA G130: Proporcionar encabezados descriptivos","icon_descriptive-headings_rstFail", "AA",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 3.1.1: Idioma de la página      ","icon_language-determine_rstFail", "A",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 3.1.2: Idioma de las partes      ","icon_language-attributes-page_rstFail", "AA",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 3.2.2: Al recibir entradas      TÉCNICA G13: Describir lo que sucederá antes de que se realice un cambio en un control de formulario que cause que ocurra un cambio de contexto","icon_forms-without-buttons_rstFail", "A",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 3.2.2: Al recibir entradas      TÉCNICA H32: Proporcionar botones de envío de formulario","icon_submit-buttons_rstFail", "A",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 3.3.2: Etiquetas o instrucciones      TÉCNICA H71: Proporcionar una descripción para grupos de controles de formulario utilizando los elementos <fieldset> y <legend>","icon_h71-sturcture_rstFail", "A",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 3.3.2: Etiquetas o instrucciones      TÉCNICA G167: Usar un botón adyacente para etiquetar el propósito de un campo","icon_button-form-control_rstFail", "A",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 3.3.2: Etiquetas o instrucciones      TÉCNICA G131: Proporcionar etiquetas descriptivas","icon_descriptive-labels_rstFail", "A",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 4.1.1: Procesamiento      ","icon_referencing-element_rstFail", "A",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 4.1.1: Procesamiento      ","icon_id-unique-value_rstFail", "A",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 4.1.2: Nombre, función, valor      TÉCNICA H64: Usando el atributo <title> de los elementos <frame> y <iframe>","icon_title-frame-iframe_rstFail", "A",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 4.1.2: Nombre, función, valor      TÉCNICA H65: Usar el atributo <title> para identificar los controles de formulario cuando no se puede usar el elemento <label>","icon_title-attribute-form-control_rstFail", "A",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 4.1.2: Nombre, función, valor      FALLO F89: Fallo de los Criterios de Conformidad 2.4.4, 2.4.9 y 4.1.2 debido a que no se proporciona un nombre accesible para una imagen que es el único contenido en un enlace","icon_null-alt-image_rstFail", "A",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 4.1.2: Nombre, función, valor      TÉCNICA H91: Usar controles de formulario HTML y enlaces","icon_form-controls-links_rstFail", "A",driver)
    datosProblema("CRITERIO DE CONFORMIDAD: 4.1.2: Nombre, función, valor      FALLO F59: Fallo del Criterio de Conformidad 4.1.2 debido al uso de secuencias de comandos para hacer que los elementos <div> o <span> sean un control de la interfaz de usuario en HTML sin proporcionar una función para el control","icon_script-ui-control_rstFail", "A",driver)
   '''
    Uso de <alt> en elementos <img> [1.1.1]
    Uso del color [1.4.1] A
    Uso de controladores de eventos específicos del dispositivo señalador únicamente [2.1.1] A
    Se proporcionan títulos descriptivos para las páginas web [2.4.2] A
    Se Proporcionan enlaces para navegar a páginas web relacionadas [2.4.5] AA
    Se roporcionan encabezados descriptivos [2.4.6] AA
    Lenguaje principal de la página indicado [3.1.1] A
    Idioma de las partes [3.1.2] AA
    Enviar formularios sin enviar botones [3.2.2] A
    Se proporciona un botón de enviar para iniciar un cambio de contexto [3.2.2] A
    Etiquetar grupos de elementos de formulario [3.3.2] A
    Elementos de referencia [4.1.1] A
    Definir identificadores para elementos [4.1.1] A
    Usar <title> para los elementos frame e iframe [4.1.2] A
    Nombre accesible para imágenes con enlace [4.1.2] A
    Se utilizan los controles y enlaces de formulario HTML [4.1.2] A
    Se proporciona el nombre del rol para <div> / <span> con el controlador de eventos [4.1.2] A


    icon_alt-on-img_rstFail
    icon_use-color_rstFail
    icon_pointing-device-events_rstFail
    icon_title-not-descriptive_rstFail
    icon_links-webpages_rstFail
    icon_descriptive-headings_rstFail
    icon_language-determine_rstFail
    icon_language-attributes-page_rstFail
    icon_forms-without-buttons_rstFail
    icon_submit-buttons_rstFail
    icon_h71-sturcture_rstFail
    icon_referencing-element_rstFail
    icon_id-unique-value_rstFail
    icon_title-frame-iframe_rstFail
    icon_null-alt-image_rstFail
    icon_form-controls-links_rstFail
    icon_script-ui-control_rstFail
'''
    cursor = cursor.execute("insert into eiiicheckers(pagina_id,puntuacion,num_problemas, num_aciertos,num_problemas_a,num_problemas_aa,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),puntuacion,num_problemas, num_aciertos,num_problemas_a,num_problemas_aa,ruta_BD,fecha_test,))
    desconexionBD(conexion,cursor)

except Exception as e:
    errorLog(directorio,1,getFecha(),herramienta,pagina_id,e)


driver.quit()