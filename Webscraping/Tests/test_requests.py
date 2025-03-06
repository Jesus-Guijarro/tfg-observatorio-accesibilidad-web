import requests

#pagina_web="https://www.uv.es/master-ultimes-places/ca/admissio-master/admissio-ultimes-places/1-escull-master.html"
#pagina_web = "http://www.mecd.gob.es/cultura-mecd/areas-cultura/archivos.html"
#pagina_web="https://www.umh.es/"

pagina_web="http://www.gva.es/es/inicio/administraciones/adm_tramites_y_servicios"
headers = {'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.80 Safari/537.36'}
request = requests.get(pagina_web,headers=headers,allow_redirects=False)
print(request.status_code)
print(request.history)

pagina_web="http://www.gva.es/es/inicio/ciudadanos/ciu_busco_trabajo"
request = requests.get(pagina_web, allow_redirects=False)
print(request.status_code)

'''
print(str(request.content).replace(' ',''))
print(len(request.content))
print(len(str(request.content).replace(' ','')))
print(len(request.text)) #
print(len(str(request.text).replace(' ',''))) #

print(request.status_code)

print(request.history)
print(request.url)

if len(request.history) !=0:
    print(request.url)
'''


