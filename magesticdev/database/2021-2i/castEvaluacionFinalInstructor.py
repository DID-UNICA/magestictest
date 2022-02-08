import pandas as pd
from castProfesores import getProfesores
from castCatalogoCursos import getCatalogo
from castCursos import getCursos
from castParticipanteCurso import getParticipantes
from castInstructorCurso import getInstructores
import evaluacion_final_instructor as efc

def getEvaluaciones():
    evaluaciones = pd.ExcelFile('../Instructores_Evaluación_Final.xlsx')
    registros = evaluaciones.parse(0)

    registros_evaluaciones = {}
    count = 0
    campos = registros.keys().tolist()

    print("Obteniendo catalogo de cursos")
    registro_participantes = getParticipantes()
    print("Obteniendo Participantes")
    registro_instructores = getInstructores()
    print("Obteniendo cursos")
    registros_cursos = getCursos()
    registros_profesores = getProfesores()
    print("Obteniendo profesores")
    registros_catalogo = getCatalogo()

    print(campos)

    contador = 1
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
        semestre = vars[1].split('-')
        semestreInt = int(semestre[0])
        if(semestreInt >= 2014):
            efc.EvaluacionFinalInstructor.count = contador
            registro = efc.EvaluacionFinalInstructor(vars)
            registros_evaluaciones[count] = registro
            fkCurso = 0
            fkCatalogo = 0

            for catalogo in registros_catalogo:
                if(registros_catalogo[catalogo].getCVECurso() == vars[0]):
                    fkCatalogo = catalogo + 1
                    break

            for curso in registros_cursos:
                if(registros_cursos[curso].getSemestre() == vars[1] and registros_cursos[curso].getCatalogoId() == fkCatalogo):
                    fkCurso = registros_cursos[curso].getPK()

            fkProfesor = 0
            for profesor in registros_profesores:
                if(registros_profesores[profesor].getRFC() == vars[4]):
                    fkProfesor = profesor + 1

            fk = 0
            for participante in registro_participantes:
                if(registro_participantes[participante].getCurso_id() == fkCurso and registro_participantes[participante].getProfesor_id() == fkProfesor):
                    fk = registro_participantes[participante].getPK()

            registros_evaluaciones[count].setParticipante_id(fk)

            fkProfesor = 0
            for profesor in registros_profesores:
                if(registros_profesores[profesor].getRFC() == vars[3]):
                    fkProfesor = registros_profesores[profesor].getPK()

            fk = 0
            for instructor in registro_instructores:
                if(registro_instructores[instructor].getCurso_id() == fkCurso and registro_instructores[instructor].getProfesor_id() == fkProfesor):
                    fk = registro_instructores[instructor].getPK()
        
            registros_evaluaciones[count].setInstructor_id(fk)
            contador += 1

    return registros_evaluaciones

registro_evaluaciones = getEvaluaciones()
f = open("Evaluacion_final_instructor.csv","w",encoding = 'utf-8')
for registro in registro_evaluaciones:
    if(registro_evaluaciones[registro].participante_id > 0 and registro_evaluaciones[registro].instructor_id > 0):
        f.write(str(registro_evaluaciones[registro]))
f.close()


