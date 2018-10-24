
import hashlib
import codecs

def hashArchivo(ruta_archivo):
    #Se obtiene el contenido del archivo html
    f=codecs.open(ruta_archivo, 'r', encoding="utf8")
    contenido=f.read()

    #Se transforma el contenido con el algoritmo críptográfico MD5
    hash = hashlib.md5()
    hash.update(('%s' % (contenido)).encode('utf-8'))
    valor_hash= hash.hexdigest()

    return valor_hash

    