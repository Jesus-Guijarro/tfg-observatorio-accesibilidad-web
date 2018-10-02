
from conexiones import *

import mysql.connector


url="http://accesibilidadweb.dlsi.ua.es/"

parametros = conexionBD()

conexion= parametros[0]
cursor = parametros[1]

#cursor.execute("insert into sitios(idSitio,url) values(4,%s)",(url,))

lista = ["aaaaaaaaaaaaa","aaaaaaaaaaaaa","aaaaaaaaaaaaa","aaaaaaaaaaaaa"]

for i in lista:
    cursor.execute("insert into sitios(url) values(%s)",(i,))


'''
cursor.execute("select idSitio from sitios where url = %s", ("http://www.elmundo.es",))

idSitio = cursor.fetchone()

print(idSitio.__getitem__(0))
'''

desconexionBD(conexion,cursor)