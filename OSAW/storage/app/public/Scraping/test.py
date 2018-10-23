from datetime import datetime

from herramientas.conexiones import *
'''
myFile = open('/home/jesus/Documents/file.txt', 'a')  
myFile.write('\nAccessed on ' + str(datetime.now().date()))  
'''

parametros = conexionBD()

conexion= parametros[0]
cursor = parametros[1]



