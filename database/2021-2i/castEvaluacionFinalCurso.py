import evaluacion_final_curso as e
import pandas as pd

def getEvaluaciones():
    catalogo = pd.ExcelFile('../PARTICIPANTES.xlsx')
    registros = catalogo.parse(0)

    registros_evaluaciones = {}
    count = 0
    campos = registros.keys().tolist()

    print(campos)

    campos_catalogo = {}
    for campo in campos:
        campos_catalogo[campo] = registros[campo]

    count_max = 0

    for row in registros.index:
        count_max += 1

    contador_id = 0
    for count in range(0,count_max):
        vars = []
        for llave in campos_catalogo:
            vars.append(campos_catalogo[llave][count])
        semestre = vars[1].split('-')
        semestreInt = int(semestre[0])
        if(semestreInt >= 2014 and vars[17]):
            contador_id += 1
            e.EvaluacionFinal.count = contador_id
            registro = e.EvaluacionFinal(vars)
            registro.setPK(contador_id)
            registros_evaluaciones[count] = registro
    
    return registros_evaluaciones

registros_evaluaciones = getEvaluaciones()
f = open("Evaluacion_final_curso.csv","w",encoding='utf-8')
for registro in registros_evaluaciones:
    if(registros_evaluaciones[registro].participante_curso_id > 0):
        f.write(str(registros_evaluaciones[registro]))
f.close()