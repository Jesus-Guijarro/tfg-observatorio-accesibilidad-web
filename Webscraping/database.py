import mysql.connector

#Método para conectar a la BD
def conexionBD():

    conexion = mysql.connector.connect(user='jesus', password='bS_`83b45Yl3v+c',
                              host='127.0.0.1',
                              database='OSAW')
    cursor = conexion.cursor()

    parametros = []

    parametros.append(conexion)
    parametros.append(cursor)

    return parametros

#Se realizan los cambios y se cierra la BD
def desconexionBD(conexion):

    conexion.commit()
    conexion.close()