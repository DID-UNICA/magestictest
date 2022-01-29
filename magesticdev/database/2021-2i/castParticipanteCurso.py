import pandas as pd
import participante_curso as pc
from  castCursos import getCursos
from castProfesores import getProfesores
from castCatalogoCursos import getCatalogo

def getParticipantes():
    catalogo = pd.ExcelFile('../PARTICIPANTES.xlsx')
    registros = catalogo.parse(0)

    registros_participantes = {}
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

    for count in range(0,count_max):
        vars = []
        for llave in campos_catalogo:
            vars.append(campos_catalogo[llave][count])

        if(vars[1] == '2021-2i'):
            pc.ParticipanteCurso.count = count+1
            registro = pc.ParticipanteCurso(vars)
            registros_participantes[count] = registro
            fk = 0
            fkCatalogo = 0
            for catalogo in registros_catalogo:
                if(registros_catalogo[catalogo].getCVECurso() == vars[2]):
                    fkCatalogo = catalogo + 1
                    break
            for curso in registros_cursos:
                if(registros_cursos[curso].getSemestre() == vars[1] and registros_cursos[curso].getCatalogoId() == fkCatalogo):
                    fk = curso + 1
            registros_participantes[count].setCurso_id(fk)
            fk = 0
            for profesor in registros_profesores:
                if(registros_profesores[profesor].getRFC() == vars[4]):
                    fk = profesor + 1
                    break
            registros_participantes[count].setProfesor_id(fk)
        
    return registros_participantes

registros_participantes = getParticipantes()
f = open("Participante_curso.csv","w",encoding='utf-8')
for registro in registros_participantes:
    f.write(str(registros_participantes[registro]))
f.close()

