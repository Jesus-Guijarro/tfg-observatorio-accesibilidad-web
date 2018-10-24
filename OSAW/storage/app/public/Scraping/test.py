from datetime import datetime
import os,sys,json

'''
from test2 import *
p1 = Person("John", 36)
p1.myfunc()

myFile = open('/home/jesus/Documents/file.txt', 'a')  
myFile.write(str(datetime.now().date()))  
'''

data = {
   "status":{
      "success":True,
      "httpstatuscode":200
   },
   "statistics":{
      "pagetitle":"Google",
      "pageurl":"google.com",
      "time":1.27,
      "allitemcount":31,
      "totalelements":178,
      "waveurl":"http:\/\/wave.webaim.org\/report?url=http:\/\/google.com\/"
   },
   "categories":{
      "error":{
         "description":"Errors",
         "count":4,
         "items":{
            "language_missing":{
               "id":"language_missing",
               "description":"Document language missing",
               "count":1
            },
            "alt_spacer_missing":{
               "id":"alt_spacer_missing",
               "description":"Spacer image missing alternative text",
               "count":1
            },
            "link_empty":{
               "id":"link_empty",
               "description":"Empty link",
               "count":1
            },
            "label_missing":{
               "id":"label_missing",
               "description":"Missing form label",
               "count":1
            }
         }
      },
      "alert":{
         "description":"Alerts",
         "count":5,
         "items":{
            "h1_missing":{
               "id":"h1_missing",
               "description":"Missing first level heading",
               "count":1
            },
            "title_redundant":{
               "id":"title_redundant",
               "description":"Redundant title text",
               "count":1
            },
            "label_title":{
               "id":"label_title",
               "description":"Unlabeled form element with title",
               "count":1
            },
            "link_suspicious":{
               "id":"link_suspicious",
               "description":"Suspicious link text",
               "count":1
            },
            "heading_skipped":{
               "id":"heading_skipped",
               "description":"Skipped heading level",
               "count":1
            }
         }
      },
      "feature":{
         "description":"Features",
         "count":1,
         "items":{
            "alt_link":{
               "id":"alt_link",
               "description":"Linked image with alternative text",
               "count":1
            }
         }
      },
      "structure":{
         "description":"Structural Elements",
         "count":5,
         "items":{
            "table_layout":{
               "id":"table_layout",
               "description":"Layout table",
               "count":2
            },
            "ol":{
               "id":"ol",
               "description":"Ordered list",
               "count":1
            },
            "h2":{
               "id":"h2",
               "description":"Heading level 2",
               "count":1
            },
            "iframe":{
               "id":"iframe",
               "description":"Inline Frame",
               "count":1
            }
         }
      },
      "html5":{
         "description":"HTML5 and ARIA",
         "count":4,
         "items":{
            "aria":{
               "id":"aria",
               "description":"ARIA",
               "count":4
            }
         }
      },
      "contrast":{
         "description":"Contrast Errors",
         "count":2,
         "items":{
            "contrast":{
               "id":"contrast",
               "description":"Very Low Contrast",
               "count":2
            }
         }
      }
   }
}

datos_string = json.dumps(data)

datos_json = json.loads(datos_string)

num_problemas = datos_json["categories"]["error"]["count"]
num_advertencias= datos_json["categories"]["alert"]["count"]
num_caracteristicas= datos_json["categories"]["feature"]["count"]
num_elem_ARIA= datos_json["categories"]["html5"]["count"]
num_problemas_contraste= datos_json["categories"]["contrast"]["count"]

def obtenerDatos(datos):
    valores = datos.values()
    #claves = datos.keys()
    for v in valores:
        print(str(v["description"]) +" -- "+ str(v["count"]))

obtenerDatos(datos_json["categories"]["error"]["items"])
obtenerDatos(datos_json["categories"]["alert"]["items"])
obtenerDatos(datos_json["categories"]["feature"]["items"])
obtenerDatos(datos_json["categories"]["contrast"]["items"])


directorio = os.path.dirname(os.path.abspath(__file__))

directorio=directorio.replace("/Scraping/herramientas","")
directorio=directorio.replace("/storage/app","")

fecha_test=str(datetime.now().date())

ruta_reporte=directorio+"/storage/"+herramienta+"/"+pagina_id+"_"+str(fecha_test)+".txt"
ruta_BD="/storage/"+herramienta+"/"+pagina_id+"_"+str(fecha_test)+".txt"

#Crear reporte
reporte = open(ruta_reporte, 'a')



