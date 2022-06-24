import profesores as p
import pandas as pd
import numpy as np

def getProfesores():
    catalogo = pd.ExcelFile('../Profesores.xlsx')
    df = pd.read_excel('../Profesores.xlsx')
    df['No_trabajador'].fillna('')
    registros = catalogo.parse(0)

    registros_profesores = {}
    count = 0
    recuperado = []
    campos = registros.keys().tolist()

    campos_profesores = {}
    for campo in campos:
        campos_profesores[campo] = registros[campo]

    count_max = 0
    for row in registros.index:
        count_max += 1

    for count in range(0,count_max):
        vars = []

        #print(df.loc[count,'No_trabajador'])
        for llave in campos_profesores:
            vars.append(campos_profesores[llave][count])
        p.Profesor.count = count+1
        if(vars[0] != 'XXXX999999' and vars[0] != 'aaaa' and vars[0] != "alu 13" and vars[0] != "Alu 4" and vars[0] != "Alu 5" and vars[0] != "ALU 8" and vars[0] != "alu1" and vars[0] != "alu10" and vars[0] != "alu11" and vars[0] != "alu12" and vars[0] != "alu2" and vars[0] != "Alu3" and vars[0] != "Alumno 11" and vars[0] != "Alumno 12" and vars[0] != "Alumno 13" and vars[0] != "Alumno 14" and vars[0] != "Alumno 15" and vars[0] != "Alumno 16" and vars[0] != "Alumno 17"  and vars[0] != "ALUMNO 9" and vars[0] != "alumno10"  and not ('PROFESOR' in vars[6].upper()) and not 'ZARL4401' in vars[0] and not 'CUSR721101' in vars[0] and not 'GARP750625' in vars[0] and not 'JILA600913' in vars[0] and not 'PARJ541107' in vars[0]):
            registro = p.Profesor(vars,'' if np.isnan(df.loc[count,'No_trabajador']) else str(df.loc[count,'No_trabajador']),df.loc[count,'Nombre para Diploma'])
            registros_profesores[count]=registro
    return registros_profesores

registros_profesores = getProfesores()
f = open("Profesores.csv","w",encoding='utf-8')
for registro in registros_profesores:
    if( not registro+1 in [1113,2335,1718,3647]):
        f.write(str(registros_profesores[registro]))
f.close()