from herramienta import getDirectorioOSAW , getRutaReporte ,getRutaReporte

directorio = getDirectorioOSAW()

ruta_reporte=getRutaReporte(directorio,"wave",1,"20-20")
ruta_BD=getRutaReporte("","wave",1,"20-20")

print (ruta_reporte)
print (ruta_BD)