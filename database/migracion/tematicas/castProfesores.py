import profesores as p
import pandas as pd
import numpy as np

def getProfesores():
    df = pd.read_csv('Profesores.csv', sep='|')

    registros_profesores = {}
    count = 0
    recuperado = []
    campos = df.columns.to_list()

    campos_profesores = {}
    for campo in campos:
        campos_profesores[campo] = df[campo]

    count_max = len(df.index)

    for count in range(0,count_max):
        vars = []

        #print(df.loc[count,'No_trabajador'])
        for llave in campos_profesores:
            vars.append(df.loc[count,llave])
        p.Profesor.count = count+1
        registro = p.Profesor(vars)
        registros_profesores[count]=registro
    return registros_profesores

registros_profesores = getProfesores()