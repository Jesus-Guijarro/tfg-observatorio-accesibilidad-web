import requests

pagina_web="http://www.gva.es/es/inicio/ciudadanos/ciu_necesito_ir_al_medico"

def comprobarAccesoyTipo(pagina_web):
    try:
        #No se verifica el certificado SSL de la web - UMH
        request = requests.get(pagina_web, verify=False, timeout=20)

        tipo = request.headers.get('content-type')

        print(tipo)
        print(request.status_code)

        #Tipo de contenido buscado -> "text/html"
        tipo = tipo.lower().replace(' ','')

        #Comprobamos si obtenemos respuesta satisfactoria y el tipo del contenido es text/html
        if request.status_code == 200 and "text/html" in tipo:
            return True
        else:
            return False
    except requests.ConnectionError:
        return False

print(comprobarAccesoyTipo(pagina_web))