from crontab import CronTab

cron = CronTab(user='jesus')

job1 = cron.new(command='/usr/bin/python3 /home/jesus/Documents/test.py', comment='prueba1')  

job2 = cron.new(command='/usr/bin/python3 /home/jesus/Documents/test.py', comment='prueba2')  

job1.minute.every(1)
job2.minute.every(1)

#ESCRITURA

'''
from datetime import datetime  

myFile = open('/home/jesus/Documents/file.txt', 'a')  
myFile.write('\nAccessed on ' + str(datetime.now()))  
'''


#BORRADO
'''
jobs=cron.find_comment('prueba1')  

for job in jobs: 
    cron.remove(job)  

'''

cron.write() 