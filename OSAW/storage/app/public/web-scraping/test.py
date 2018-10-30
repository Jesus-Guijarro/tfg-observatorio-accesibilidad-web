from comprobador import *
from conexiones import *

parametros = conexionBD()
conexion= parametros[0]
cursor = parametros[1]


cursor.execute("select count(*) from waves where pagina_id = %s order by id desc limit 1", (pagina_id,))
            
resultado = cursor.fetchone()
cantidad=resultado.__getitem__(0)
#Si el resultado es 0 se comprueba y se añade en caso de que se pueda acceder a ella
if cantidad>0:

desconexionBD(conexion,cursor)

