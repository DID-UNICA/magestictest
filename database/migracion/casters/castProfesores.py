from casters.models import profesores as p
import pandas as pd
import numpy as np
from casters import rutas
from casters.rutas import route_factories,route_excel

def getProfesores():
    df = pd.read_excel(route_excel+'Profesores.xlsx')
    df['No_trabajador'].fillna('')
    df = df.replace(to_replace=[r"\\t|\\n|\\r", "\t|\n|\r","_x000d_"], value=["",""," "], regex=True)

    registros_profesores = {}
    count = 0

    count_max = len(df.index)

    for count in range(0,count_max):
        vars = df.loc[count]
        p.Profesor.count = count+1
        if(vars['RFC_profesor'] not in ['XXXX999999','aaaa',"alu 13","Alu 4", "Alu 5", "ALU 8", "alu1", "alu10", "alu11", "alu12", "alu2", "Alu3", "Alumno 11", "Alumno 12", "Alumno 13", "Alumno 14", "Alumno 15", "Alumno 16", "Alumno 17" , "ALUMNO 9", "alumno10"] and not 'ZARL4401' in vars['RFC_profesor'] and not 'CUSR721101' in vars['RFC_profesor'] and not 'GARP750625' in vars['RFC_profesor'] and not 'JILA600913' in vars['RFC_profesor'] and not 'PARJ541107' in vars['RFC_profesor']  and not ('PROFESOR' in vars["Nombres"].upper())):
            registro = p.Profesor(vars)
            registros_profesores[vars['RFC_profesor']]=registro
    return registros_profesores

def writeProfesores():
    registros_profesores = getProfesores()
    f = open(route_factories+"Profesores.csv","w",encoding='utf-8')
    for registro in registros_profesores:
        if( not registros_profesores[registro].getPK() in [1113,2335,1718,3647]):
            f.write(str(registros_profesores[registro]))
    f.close()