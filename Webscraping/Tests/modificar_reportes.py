import os

files = []

for file in os.listdir("/home/jesus/TFG/OSAW/storage/app/public/vamola/"):
    if file.endswith(".txt"):
        files.append(os.path.join("/home/jesus/TFG/OSAW/storage/app/public/vamola/", file))

for ruta in files:

    # Read in the file
    with open(ruta, 'r') as file :
        filedata = file.read()

    # Replace the target string
    #Achecker y Vamolà
    filedata = filedata.replace('Congratulations! No known problems.', 'Ningún problema conocido encontrado.')
    filedata = filedata.replace('Congratulations! No potential problems.', 'Ningún problema potencial encontrado.')
    

    #WAVE
    #filedata = filedata.replace('-------------------------------------------------------------------', '\n\n')

    # Write the file out again
    with open(ruta, 'w') as file:
        file.write(filedata)
