from datetime import datetime
from database import conexionBD,desconexionBD

import os,sys,json

data = {"status":{"success":True,"httpstatuscode":200},"statistics":{"pagetitle":"Inicio - Ministerio de Educación, Cultura y Deporte","pageurl":"https:\/\/www.mecd.gob.es\/portada-mecd\/",
"time":"2.51","creditsremaining":7998,"allitemcount":194,"totalelements":740,"waveurl":"http:\/\/wave.webaim.org\/report?url=https:\/\/www.mecd.gob.es\/portada-mecd\/"},
"categories":{"error":{"description":"Errors","count":3,"items":{"button_empty":{"count":1,"description":"Empty button","id":"button_empty"},"link_empty":{"count":2,"description":
"Empty link","id":"link_empty"}}},"contrast":{"description":"Contrast Errors","count":1,"items":{"contrast":{"count":1,"description":"Very Low Contrast","id":"contrast"}}},
"alert":{"description":"Alerts","count":48,"items":{"alt_long":{"count":2,"description":"Long alternative text","id":"alt_long"},"alt_redundant":{"count":1,"description":
"Redundant alternative text","id":"alt_redundant"},"link_internal_broken":{"count":12,"description":"Broken same-page link","id":"link_internal_broken"},"link_pdf":{"count":4,
"description":"Link to PDF document","id":"link_pdf"},"link_redundant":{"count":1,"description":"Redundant link","id":"link_redundant"},"noscript":{"count":1,"description":
"Noscript element","id":"noscript"},"text_justified":{"count":9,"description":"Justified text","id":"text_justified"},"title_redundant":{"count":18,"description":"Redundant title text",
"id":"title_redundant"}}},"feature":{"description":"Features","count":100,"items":{"alt":{"count":9,"description":"Alternative text","id":"alt"},"alt_link":{"count":80,"description":
"Linked image with alternative text","id":"alt_link"},"alt_null":{"count":1,"description":"Null or empty alternative text","id":"alt_null"},"alt_spacer":{"count":2,"description":
"Null or empty alternative text on spacer","id":"alt_spacer"},"fieldset":{"count":1,"description":"Fieldset","id":"fieldset"},"label":{"count":1,"description":"Form label","id":"label"},
"lang":{"count":6,"description":"Element language","id":"lang"}}},"structure":{"description":"Structural Elements","count":40,"items":{"h1":{"count":2,"description":"Heading level 1",
"id":"h1"},"h2":{"count":7,"description":"Heading level 2","id":"h2"},"h3":{"count":4,"description":"Heading level 3","id":"h3"},"iframe":{"count":4,"description":"Inline Frame","id":
"iframe"},"ul":{"count":23,"description":"Unordered list","id":"ul"}}},"html5":{"description":"HTML5 and ARIA","count":2,"items":{"aria":{"count":2,"description":"ARIA","id":"aria"}}}}}

datos_string = json.dumps(data)

datos_json = json.loads(datos_string)

datos_json.get("categories")

num_problemas = datos_json["categories"]["error"]["count"]
num_advertencias= datos_json["categories"]["alert"]["count"]
num_caracteristicas= datos_json["categories"]["feature"]["count"]
num_elem_ARIA= datos_json["categories"]["html5"]["count"]
num_problemas_contraste= datos_json["categories"]["contrast"]["count"]


directorio = os.path.dirname(os.path.abspath(__file__))

pagina_id=1
directorio=directorio.replace("/Webscraping","")
directorio=directorio.replace("/storage/app","")

fecha_test=str(datetime.now().date())

ruta_reporte=directorio+"/wave/1_"+str(fecha_test)+".txt"
#ruta_reporte=directorio+"/"+herramienta+"/"+pagina_id+"_"+str(fecha_test)+".txt"
ruta_BD="/test.txt"

#Crear reporte
reporte = open(ruta_reporte, 'a')


def obtenerDatos(categoria,datos):
    valores = datos.values()
    #claves = datos.keys()
    reporte.write(categoria+"\n")
    for v in valores:
        reporte.write(str(v["description"]) +"\t Cantidad: "+ str(v["count"])+"\n")
    reporte.write("-------------------------------------------------------------------\n")


#En algunos casos alguna de las categorias no tiene elementos
try:
    obtenerDatos("PROBLEMAS",datos_json["categories"]["error"]["items"])
except Exception as e:
    pass
try:
    obtenerDatos("ALERTAS",datos_json["categories"]["alert"]["items"])
except Exception as e:
    pass
try:
    obtenerDatos("CARACTERISTICAS",datos_json["categories"]["feature"]["items"])
except Exception as e:
    pass
try:
    obtenerDatos("PROBLEMAS DE CONTRASTE",datos_json["categories"]["contrast"]["items"])
except Exception as e:
    pass


parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

cursor.execute("insert into waves(pagina_id,datos_problemas,fecha_test,num_problemas, num_advertencias, num_caracteristicas, num_elem_ARIA, num_problemas_contraste)values(%s,%s,%s,%s,%s,%s,%s,%s)",(int(pagina_id),ruta_BD,fecha_test,num_problemas, num_advertencias, num_caracteristicas, num_elem_ARIA, num_problemas_contraste,))
desconexionDB(conexion)





