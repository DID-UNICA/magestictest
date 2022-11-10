from casters.models import evaluacion_final_curso as e
import pandas as pd
from casters import castParticipanteCurso,rutas
from casters.castParticipanteCurso import  getParticipantes
from casters.rutas import route_factories,route_excel

def getEvaluaciones():
    df = pd.read_excel(route_excel+'PARTICIPANTES.xlsx')

    registros_evaluaciones = {}
    registro_participantes = getParticipantes()


    count_max = len(df.index)

    contador_id = 0
    for count in range(0,count_max):
        vars = df.loc[count]
        semestre = vars['semestre'].split('-')
        semestreInt = int(semestre[0])
        if(semestreInt >= 2022):
            key = (vars['semestre'],vars['cve_curso'],vars['grupo'],vars['RFC_profesor'])
            registro = e.EvaluacionFinal(vars)
            try:
                contador_id = registro_participantes[key].getPK()
            except:
                continue
            e.EvaluacionFinal.count = contador_id
            registro.setPK(contador_id)
            registros_evaluaciones[count] = registro


    return registros_evaluaciones

def writeEvaluacionesCurso():
    registros_evaluaciones = getEvaluaciones()
    f = open(route_factories+"Evaluacion_final_curso.csv","w",encoding='utf-8')
    for registro in registros_evaluaciones:
        if(registros_evaluaciones[registro].participante_curso_id > 0):
            f.write(str(registros_evaluaciones[registro]))
    f.close()