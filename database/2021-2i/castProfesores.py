import profesores as p
import pandas as pd
import numpy as np

def getProfesores():
    catalogo = pd.ExcelFile('../Profesores.xlsx')
    df = pd.read_excel('../Profesores.xlsx')
    registros = catalogo.parse(0)

    registros_profesores = {}
    count = 0
    recuperado = []
    campos = registros.keys().tolist()
    campos_profesores = {}
    for campo in campos:
        campos_profesores[campo] = registros[campo]

    print(df.columns)
    df['No_trabajador'].fillna(0)

    count_max = 0
    for row in registros.index:
        count_max += 1

    for count in range(0,count_max):
        vars = []

        #print(df.loc[count,'No_trabajador'])
        for llave in campos_profesores:
            vars.append(campos_profesores[llave][count])
        p.Profesor.count = count+1
        registro = p.Profesor(vars,'' if np.isnan(df.loc[count,'No_trabajador']) else str(df.loc[count,'No_trabajador']))
        registros_profesores[count]=registro
    return registros_profesores

registros_profesores = getProfesores()
f = open("Profesores.csv","w",encoding='utf-8')
for registro in registros_profesores:
    f.write(str(registros_profesores[registro]))
f.close()