from datetime import datetime  

myFile = open('/home/jesus/Documents/file.txt', 'a')  
myFile.write('\nAccessed on ' + str(datetime.now().date()))  





