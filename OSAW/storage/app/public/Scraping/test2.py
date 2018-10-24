from miscelaneo import *

import os

directorio = os.path.dirname(os.path.abspath(__file__))
print(directorio)
directorio=directorio.replace("/Scraping","")
directorio=directorio.replace("/storage/app","")
print(directorio)


print(getDirectorio())

