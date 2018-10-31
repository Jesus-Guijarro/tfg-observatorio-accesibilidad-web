from comprobaciones import *
from conexiones import *


pagina_web="http://www.valencia.es/ayuntamiento/Mercados.nsf/vDocumentosTituloAux/Inicio?opendocument&lang=2&nivel=1"
pagina_id=177

print(comprobarAccesoyTipo(pagina_web))
print(comprobarCopiaHTML(pagina_id))



