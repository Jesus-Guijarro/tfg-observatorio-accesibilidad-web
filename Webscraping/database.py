import mysql.connector

#Método para conectar a la BD
def conexionDB():

    conexion = mysql.connector.connect(user='jesus', password='OSAW2018-',
                              host='127.0.0.1',
                              database='OSAW')
    cursor = conexion.cursor()

    parametros = []

    parametros.append(conexion)
    parametros.append(cursor)

    return parametros

#Se realizan los cambios y se cierra la BD
def desconexionDB(conexion):

    conexion.commit()
    conexion.close()