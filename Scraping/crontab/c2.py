from crontab import CronTab

cron = CronTab(user=True)

urls= ['/home/jesus/Documentos/crawler.py http://accesibilidadweb.dlsi.ua.es']


for url in urls:

    com='/usr/bin/python3 '+url

    #Ejecución a las 12:00 los Domingos
    job = cron.new(command=com)
    job.minutes.every(2)

    com=''

cron.write()
