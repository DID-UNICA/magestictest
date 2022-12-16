import pandas as pd

route_factories = '../../../factories/fromAccess/'

archivo = open(route_factories+'Profesores.csv','r', encoding="utf8")
datos = archivo.readlines()

profesores = 1
for dato in datos:
    if(dato.find('"') != -1):
        cadenas = dato.split("|")
        comilla = 0
        for char in cadenas[13]:
            if(char == '"'):
                comilla = comilla + 1
        if(comilla % 2 != 0):
            print(cadenas[13])
            print(profesores,comilla)
    profesores = profesores + 1
