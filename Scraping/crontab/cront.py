from crontab import CronTab

cron = CronTab(user=True)

urls= ['/home/jesus/webscraping/accessmonitor.py','/home/jesus/webscraping/achecker.py','/home/jesus/webscraping/examinator.py',
'/home/jesus/webscraping/eiii.py','/home/jesus/webscraping/hearcolors.py',
'/home/jesus/webscraping/sortsite.py','/home/jesus/webscraping/vamola.py']


for url in urls:

    com='/usr/bin/python3 '+url

    #Ejecución a las 12:00 los Domingos
    job = cron.new(command=com)
    job.minute.on(0)
    job.hour.on(12)
    job.dow.on('SUN')

    com=''

cron.write()
