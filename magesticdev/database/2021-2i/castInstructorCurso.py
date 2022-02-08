from castProfesores import getProfesores
from castCatalogoCursos import getCatalogo
from castCursos import getCursos
import profesor_curso as pc

import pandas as pd



def getInstructores():
    instructores = pd.ExcelFile('../Instructores.xlsx')
    registros = instructores.parse(0)

    registros_instructores = {}
    count = 0
    campos = registros.keys().tolist()

    print("Obteniendo cursos")
    registros_cursos = getCursos()
    registros_profesores = getProfesores()
    print("Obteniendo profesores")
    registros_catalogo = getCatalogo()
    print("Obteniendo catalogo de cursos")

    print(campos)

    campos_catalogo = {}

    for campo in campos:
        campos_catalogo[campo] = registros[campo]

    count_max = 0

    for row in registros.index:
        count_max += 1

    contador = 1
    for count in range(0,count_max):
        vars = []
        for llave in campos_catalogo:
            vars.append(campos_catalogo[llave][count])
        semestre = vars[1].split('-')
        semestreInt = int(semestre[0])
        if(semestreInt >= 2014):
            pc.ProfesorCurso.count = contador 
            registro = pc.ProfesorCurso(vars)
            registros_instructores[count] = registro
            print(count)
            fkCatalogo = 0
            fk = 0
            print(vars[0]+','+vars[1])
            for catalogo in registros_catalogo:
                if(registros_catalogo[catalogo].getCVECurso() == vars[0]):
                    print(registros_catalogo[catalogo].getCVECurso())
                    fkCatalogo = registros_catalogo[catalogo].getPK()
                    break
            for curso in registros_cursos:
                if(registros_cursos[curso].getSemestre() == vars[1] and registros_cursos[curso].getCatalogoId() == fkCatalogo):
                    print(registros_cursos[curso].getSemestre())
                    fk = registros_cursos[curso].getPK()

            registros_instructores[count].setCurso_id(fk)
            fk = 0
            for profesor in registros_profesores:
                if(registros_profesores[profesor].getRFC() == vars[2]):
                    fk = profesor + 1
                    break
            
            registros_instructores[count].setProfesor_id(fk)
            contador += 1
    return registros_instructores

registros_instructores = getInstructores()
f = open("Profesor_curso.csv","w",encoding='utf-8')
for registro in registros_instructores:
    if(registros_instructores[registro].curso_id > 0):
        f.write(str(registros_instructores[registro]))
f.close()