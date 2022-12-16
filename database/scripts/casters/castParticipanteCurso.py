import pandas as pd
from casters import castProfesores,castCatalogoCursos,castCursos,rutas
from casters.models import participante_curso as pc
from casters.castCursos import getCursos
from casters.castProfesores import getProfesores
from casters.castCatalogoCursos import getCatalogo
from casters.rutas import route_factories,route_excel

def getParticipantes():
    df = pd.read_excel(route_excel+'PARTICIPANTES.xlsx')

    registros_participantes = {}
    count = 0

    registros_cursos = getCursos()
    registros_profesores = getProfesores()
    registros_catalogo = getCatalogo()

    count_max = len(df.index)

    contador = 1
    for count in range(0,count_max):
        vars = df.loc[count]

        semestre = vars['semestre'].split('-')
        semestreInt = int(semestre[0])
        if(semestreInt >= 2022):
            key = (vars['semestre'],vars['cve_curso'],vars['grupo'],vars['RFC_profesor'])

            contador += 1

            fk = 0
            key_curso = (vars['semestre'],vars['cve_curso'])
            try:
                fk = registros_cursos[key_curso].getPK()
            except:
                print("Error en participante con clave {0}".format(key))
                continue

            pc.ParticipanteCurso.count = contador
            registro = pc.ParticipanteCurso(vars)
            registros_participantes[key] = registro
            registros_participantes[key].setCurso_id(fk)
            fk = 0
            rfc = vars['RFC_profesor'].split(' ')
            rfc = rfc[0] if len(rfc) == 1 else rfc[1]
            try:
                fk = registros_profesores[vars['RFC_profesor']].getPK()
            except:
                print("Error en participante con clave {0}".format(key))
                continue
            registros_participantes[key].setProfesor_id(fk)
        
    return registros_participantes

def writeParticipantes():
    registros_participantes = getParticipantes()
    f = open(route_factories+"Participante_curso.csv","w",encoding='utf-8')
    for registro in registros_participantes:
        f.write(str(registros_participantes[registro]))
    f.close()

