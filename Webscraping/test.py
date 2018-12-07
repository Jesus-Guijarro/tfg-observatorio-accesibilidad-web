from herramienta import getFecha, getDirectorioOSAW

fecha_test=getFecha()
directorio=getDirectorioOSAW()

pagina_web="https://web.ua.es"

ruta_archivo_logs=directorio+"/storage/logs/log_paginas.log"

log = open(ruta_archivo_logs, 'a')

log.write('EJEMPLO WEB -> ' + pagina_web)

log.close()