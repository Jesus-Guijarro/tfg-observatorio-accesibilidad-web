from database import conexionDB,desconexionDB

import requests
'''
parametros = conexionDB()
conexion= parametros[0]
cursor = parametros[1]

cursor.execute("select descripcion from herramientas where activa = %s", (True,))
herramientas = cursor.fetchall()

herramientas_activas=[]

for herramienta in herramientas:
    herramientas_activas.append(str(herramienta.__getitem__(0)))
    
print(herramientas_activas[0])

desconexionDB(conexion)

'''
pagina_web="https://www.umh.es/"
request = requests.get(pagina_web, verify=False, timeout=60)

print(request)



