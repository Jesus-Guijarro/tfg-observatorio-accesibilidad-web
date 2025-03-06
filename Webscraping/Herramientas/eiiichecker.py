#EIII Page Checker
import sys, os

directorio_import = os.path.dirname(os.path.abspath(__file__))
directorio_import = directorio_import.replace('/Herramientas','')
sys.path.append(directorio_import)

from database import conexionBD,desconexionBD
from herramienta import getDirectorioOSAW,getFecha,driverHeadlessBrowser, getRutaReporte, getCabeceraReporte, errorLog

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC


#Datos problemas y calculo de número de problemas según nivel
def getErrores(mensaje,css_selector,reporte,driver):
    try:
        veces_encontrado=int(driver.find_element_by_id(css_selector).text)
        reporte.write(mensaje+"\t\t VECES ENCONTRADO: "+ str(veces_encontrado)+"\n")
        
        return veces_encontrado

    except Exception as e:
        return 0

#Método para ejecutar el proceso de evaluación
def ejecutarEIIIChecker(pagina_id,pagina_url,herramienta,conexion,cursor):
    directorio = getDirectorioOSAW()

    fecha_test=getFecha()

    try:
        #Activamos el modo headless
        driver=driverHeadlessBrowser()

        #Pausa explicita de 20 segundos
        #Se pausa hasta que se encuentra el elemento
        wait = WebDriverWait(driver, 20) 

        #Esperamos hasta que accedemos a la web de la herramienta
        #En caso negativo se cancela el análisis y se cierra el driver
        try:
            #Accedemos a la web de la herramienta de evaluación
            driver.get('http://checkers.eiii.eu/en/pagecheck/')
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

        #Pausa de máximo 75 segundos
        wait = WebDriverWait(driver, 75)
        #Se espera hasta que se haya evaluado y ofrecido el resultado
        try:
            elem =wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "#resultsByTest > div > div.tabArea")))
        except:
            driver.quit()
            raise Exception('No se ha podido realizar la evaluación')


        puntuacion = float(driver.find_element_by_css_selector('#resultSummary > form > ul > li:nth-child(4) > div > span > span').text)
        num_problemas =  int(driver.find_element_by_css_selector('#ul-appliedtests > li:nth-child(2) > strong > span').text.replace('Fail: ',''))
        num_aciertos =  int(driver.find_element_by_css_selector('#ul-appliedtests > li:nth-child(4) > strong > span').text.replace('Pass: ',''))

        #Rutas para guardar el archivo y el acceso desde la BD
        ruta_reporte=getRutaReporte(directorio,herramienta,pagina_id,fecha_test)
        ruta_BD=getRutaReporte("",herramienta,pagina_id,fecha_test)

        #Crear reporte
        reporte = open(ruta_reporte, 'a')
        reporte.write(getCabeceraReporte(pagina_url,fecha_test))

        #Inicializamos las variables para hacer el recuento de problemas segun nivel de adecuación
        num_problemas_a = 0
        num_problemas_aa = 0
            
        #Se obtiene el número de problemas por nivel al mismo tiempo que se crea el archivo con los datos del reporte
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 1.1.1: Contenido no textual       TÉCNICA H37: Uso de <&alt> en elementos <&img>","icon_alt-on-img_rstFail", reporte,driver)
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 1.1.1: Contenido no textual       TÉCNICA H2: Combinar imagen adyacente y enlaces de texto para el mismo recurso","icon_Adjacent-image-text-links_rstFail", reporte,driver)
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 1.4.1: Uso del color ","icon_use-color_rstFail", reporte,driver)
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 2.1.1 Teclado         FALLO F54: Fallo del Criterio de Conformidad 2.1.1 debido a que solo se utilizan controladores de eventos específicos del dispositivo señalador (incluido el gesto) para una función","icon_pointing-device-events_rstFail", reporte,driver)
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 2.4.2: Titulado de páginas       FALLO F25: Fallo del Criterio de Conformidad 2.4.2 debido al título de una página web que no identifica los contenidos","icon_title-not-descriptive_rstFail", reporte,driver)
        num_problemas_aa+=getErrores("CRITERIO DE CONFORMIDAD: 2.4.5: Múltiples vías       TÉCNICA G125: Proporcionar enlaces para navegar a páginas web relacionadas","icon_links-webpages_rstFail", reporte,driver)
        num_problemas_aa+=getErrores("CRITERIO DE CONFORMIDAD: 2.4.6: Encabezados y etiquetas       TÉCNICA G130: Proporcionar encabezados descriptivos","icon_descriptive-headings_rstFail", reporte,driver)
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 3.1.1: Idioma de la página      ","icon_language-determine_rstFail", reporte,driver)
        num_problemas_aa+=getErrores("CRITERIO DE CONFORMIDAD: 3.1.2: Idioma de las partes      ","icon_language-attributes-page_rstFail", reporte,driver)
        num_problemas_aa+=getErrores("CRITERIO DE CONFORMIDAD: 3.1.2: Idioma de las partes      ","icon_Value of the xml:lang_rstFail", reporte,driver)
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 3.2.2: Al recibir entradas      TÉCNICA G13: Describir lo que sucederá antes de que se realice un cambio en un control de formulario que cause que ocurra un cambio de contexto","icon_forms-without-buttons_rstFail", reporte,driver)
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 3.2.2: Al recibir entradas      TÉCNICA H32: Proporcionar botones de envío de formulario","icon_submit-buttons_rstFail", reporte,driver)
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 3.3.2: Etiquetas o instrucciones      TÉCNICA H71: Proporcionar una descripción para grupos de controles de formulario utilizando los elementos <&fieldset> y <&legend>","icon_h71-sturcture_rstFail", reporte,driver)
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 3.3.2: Etiquetas o instrucciones      TÉCNICA G167: Usar un botón adyacente para etiquetar el propósito de un campo","icon_button-form-control_rstFail", reporte,driver)
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 3.3.2: Etiquetas o instrucciones      TÉCNICA G131: Proporcionar etiquetas descriptivas","icon_descriptive-labels_rstFail", reporte,driver)
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 4.1.1: Procesamiento      Cada elemento referido desde un atributo idref existe.","icon_referencing-element_rstFail", reporte,driver)
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 4.1.1: Procesamiento      Elementos con un atributo de identificación definido único","icon_id-unique-value_rstFail", reporte,driver)
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 4.1.1: Procesamiento      Elementos para los cuales el atributo accesskey está permitido y definido.","icon_SC4-1-1-accesskey_rstFail", reporte,driver)
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 4.1.2: Nombre, función, valor      TÉCNICA H64: Usando el atributo <&title> de los elementos <&frame> y <&iframe>","icon_title-frame-iframe_rstFail", reporte,driver)
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 4.1.2: Nombre, función, valor      TÉCNICA H65: Usar el atributo <&title> para identificar los controles de formulario cuando no se puede usar el elemento <&label>","icon_title-attribute-form-control_rstFail", reporte,driver)
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 4.1.2: Nombre, función, valor      FALLO F89: Fallo de los Criterios de Conformidad 2.4.4, 2.4.9 y 4.1.2 debido a que no se proporciona un nombre accesible para una imagen que es el único contenido en un enlace","icon_null-alt-image_rstFail", reporte,driver)
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 4.1.2: Nombre, función, valor      TÉCNICA H91: Usar controles de formulario HTML y enlaces","icon_form-controls-links_rstFail", reporte,driver)
        num_problemas_a+=getErrores("CRITERIO DE CONFORMIDAD: 4.1.2: Nombre, función, valor      FALLO F59: Fallo del Criterio de Conformidad 4.1.2 debido al uso de secuencias de comandos para hacer que los elementos <&div> o <&span> sean un control de la interfaz de usuario en HTML sin proporcionar una función para el control","icon_script-ui-control_rstFail", reporte,driver)
        
        reporte.close()

        #Guardamos los datos en la BD
        cursor = cursor.execute("insert into eiiicheckers(pagina_id,puntuacion,num_problemas, num_aciertos,num_problemas_a,num_problemas_aa,datos_problemas,fecha_test)values(%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),puntuacion,num_problemas, num_aciertos,num_problemas_a,num_problemas_aa,ruta_BD,fecha_test,))

        desconexionBD(conexion)

    except Exception as e:
        errorLog(directorio,fecha_test,herramienta,pagina_id,e)

    driver.quit()

#Argumentos
pagina_id=sys.argv[1]
pagina_url=sys.argv[2]

herramienta="eiiichecker"

#Conexion base de datos
parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

ejecutarEIIIChecker(pagina_id,pagina_url,herramienta,conexion,cursor)
desconexionBD(conexion)