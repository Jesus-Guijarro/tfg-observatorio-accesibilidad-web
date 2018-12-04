import requests

pagina_web="https://www.uv.es/master-ultimes-places/ca/admissio-master/admissio-ultimes-places/1-escull-master.html"
#pagina_web = "http://www.mecd.gob.es/cultura-mecd/areas-cultura/archivos.html"
#pagina_web="https://www.umh.es/"


request = requests.get(pagina_web)


print(request.text)
print(request.content)
print(len(request.content))

'''
print(request.history)

if len(request.history) !=0:
    print(request.url)


if request.text == '':
    print("A")
print(request.text)
'''

