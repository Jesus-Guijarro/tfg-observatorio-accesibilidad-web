
import mysql.connector

def conexionBD():

    conexion = mysql.connector.connect(user='jesus', password='2018OSAWjesus-',
                              host='127.0.0.1',
                              database='TestProject')
    cursor = conexion.cursor()

    parametros = []

    parametros.append(conexion)
    parametros.append(cursor)

    return parametros

def desconexionBD(conexion,cursor):

    conexion.commit()

    cursor.close()

    conexion.close()
