def ejecutarHerramienta(herramienta_eval,herramienta,pagina_web,pagina_id):
    if herramienta_eval:
        #Primero se obtiene el directorio actual para crear el comando a ejecutar
        directorio = getDirectorio()

        pagina_id=int(pagina_id)

        if pagina_id == 177 or pagina_id == 178 or pagina_id == 179 or pagina_id == 180:
            pagina_id=str(pagina_id)
            comando="/usr/bin/python3 "+getRutaComando(directorio,herramienta,pagina_web,pagina_id)
            print(comando)
            subprocess.run(comando, shell=True, check=True)