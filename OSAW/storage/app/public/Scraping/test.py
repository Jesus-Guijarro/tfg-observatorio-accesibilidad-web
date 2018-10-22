from datetime import datetime  
from conexiones import *

parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]

def f(num):
    
    if num == 1:
        cursor.execute("select URL from paginas where sitio_id = %s", (num,))
        sitio = cursor.fetchone()
        periodicidad=sitio.__getitem__(0)
        print(periodicidad)
        
        return True
    else:
        
        f(num-1)
        print(num)
        
f(3)


'''
myFile = open('/home/jesus/Documents/file.txt', 'a')  
myFile.write('\nAccessed on ' + str(datetime.now().date()))  
'''




