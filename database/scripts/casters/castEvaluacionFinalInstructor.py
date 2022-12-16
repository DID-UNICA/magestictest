import pandas as pd
from casters import castProfesores,castCatalogoCursos,castCursos,castParticipanteCurso,castInstructorCurso
from casters.castProfesores import getProfesores
from casters.castCatalogoCursos import getCatalogo
from casters.castCursos import getCursos
from casters.castParticipanteCurso import getParticipantes
from casters.castInstructorCurso import getInstructores
from casters.models import evaluacion_final_instructor as efc
from casters.rutas import route_factories,route_excel

def getEvaluaciones():
    df = pd.read_excel(route_excel+'Instructores_Evaluación_Final.xlsx')

    registros_evaluaciones = {}

    registro_participantes = getParticipantes()
    registro_instructores = getInstructores()
    registros_cursos = getCursos()
    registros_profesores = getProfesores()
    registros_catalogo = getCatalogo()

    contador = 0

    count_max = len(df.index)


    for count in range(0,count_max):
        vars = df.loc[count]
        semestre = vars['semestre'].split('-')
        semestreInt = int(semestre[0])
        if(semestreInt >= 2022):
            fk = 0
            try:
                fk = registro_participantes[(vars['semestre'],vars['cve_curso'],vars['grupo'],vars['RFC_profesor'])].getPK()
            except:
                print("Error en evaluacion con datos de semestre:{0}, cve_curso:{1}, grupo:{2}, rfc_profesor:{3}, rfc_ins:{4} al obtener la llave del participante".format(vars['semestre'],vars['cve_curso'],vars['grupo'],vars['RFC_profesor'],vars['RFC_inst']))
                continue

            efc.EvaluacionFinalInstructor.count = contador
            registro = efc.EvaluacionFinalInstructor(vars)
            registros_evaluaciones[count] = registro
            registros_evaluaciones[count].setParticipante_id(fk)

            fk = 0
            try:
                fk = registro_instructores[(vars['semestre'],vars['cve_curso'],vars['grupo'],vars['RFC_inst'])].getPK()
            except:
                print("Error en evaluacion con datos de semestre:{0}, cve_curso:{1}, grupo:{2}, rfc_profesor:{3}, rfc_ins:{4} Al obtener la llave del instructor".format(vars['semestre'],vars['cve_curso'],vars['grupo'],vars['RFC_profesor'],vars['RFC_inst']))
                continue
        
            registros_evaluaciones[count].setInstructor_id(fk)
            contador += 1

    return registros_evaluaciones

def writeEvaluacionesInstructor():
    registro_evaluaciones = getEvaluaciones()
    f = open(route_factories+"Evaluacion_final_instructor.csv","w",encoding = 'utf-8')
    for registro in registro_evaluaciones:
        if(registro_evaluaciones[registro].participante_id > 0 and registro_evaluaciones[registro].instructor_id > 0):
            f.write(str(registro_evaluaciones[registro]))
    f.close()


