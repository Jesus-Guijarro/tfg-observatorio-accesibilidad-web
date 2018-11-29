import os

files = []

for file in os.listdir("/home/jesus/TFG/OSAW/storage/app/public/wave/"):
    if file.endswith(".txt"):
        files.append(os.path.join("/home/jesus/TFG/OSAW/storage/app/public/wave/", file))

for ruta in files:

    # Read in the file
    with open(ruta, 'r') as file :
        filedata = file.read()

    # Replace the target string
    filedata = filedata.replace('\t\tFECHA EVALUACIÓN', '\nFECHA EVALUACIÓN')

    # Write the file out again
    with open(ruta, 'w') as file:
        file.write(filedata)
