import codecs

ruta_archivo="../OSAW/public/storage/paginas/default.html"

f=codecs.open(ruta_archivo, 'r', encoding="utf8")
contenido=f.read()

print(contenido)