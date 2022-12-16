from casters import castProfesores,castCatalogoCursos,castCursos,rutas
from casters.castProfesores import getProfesores
from casters.castCatalogoCursos import getCatalogo
from casters.castCursos import getCursos
from casters.models import profesor_curso as pc

import pandas as pd
from casters.rutas import route_factories,route_excel

def getInstructores():
    df = pd.read_excel(route_excel+'Instructores.xlsx')

    registros_instructores = {}

    registros_cursos = getCursos()
    registros_profesores = getProfesores()
    registros_catalogo = getCatalogo()

    count_max = len(df.index)

    contador = 1
    for count in range(0,count_max):
        vars = df.loc[count]
        semestre = vars[1].split('-')
        semestreInt = int(semestre[0])
        if(semestreInt >= 2022):
            key = (vars['semestre'],vars['cve_curso'],vars['grupo'],vars['RFC_inst'])
            fk = 0
            try:
                fk = registros_cursos[(vars['semestre'],vars['cve_curso'])].getPK()
            except:
                print("Error en instructor con clave {0}".format(key))
                continue

            pc.ProfesorCurso.count = contador 
            registro = pc.ProfesorCurso(vars)
            registros_instructores[key] = registro

            registros_instructores[key].setCurso_id(fk)
            fk = 0
            try:
                fk = registros_profesores[vars['RFC_inst']].getPK()
            except:
                print("Error en instructor con clave {0}".format(key))
                continue
            registros_instructores[key].setProfesor_id(fk)
            contador += 1
    return registros_instructores

def writeInstrucores():
    registros_instructores = getInstructores()
    f = open(route_factories+"Profesor_curso.csv","w",encoding='utf-8')
    for registro in registros_instructores:
        f.write(str(registros_instructores[registro]))
    f.close()