import requests

#pagina_web="https://www.uv.es/master-ultimes-places/ca/admissio-master/admissio-ultimes-places/1-escull-master.html"
#pagina_web = "http://www.mecd.gob.es/cultura-mecd/areas-cultura/archivos.html"
#pagina_web="https://www.umh.es/"
pagina_web="https://web.ua.es"

request = requests.get(pagina_web, allow_redirects=False)

'''
print(str(request.content).replace(' ',''))
print(len(request.content))
print(len(str(request.content).replace(' ','')))
print(len(request.text)) #
print(len(str(request.text).replace(' ',''))) #
'''
print(request.status_code)

print(request.history)
print(request.url)

if len(request.history) !=0:
    print(request.url)



