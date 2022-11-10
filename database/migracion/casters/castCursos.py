from casters import castCatalogoCursos,castSede,rutas
from casters.castCatalogoCursos import getCatalogo
from casters.models import cursos as C
import pandas as pd
from casters.castSede import getSedes
from casters.rutas import route_factories,route_excel

def getCursos():
    df = pd.read_excel(route_excel+'Cursos.xlsx')

    registros_cursos = {}
    count = 0

    registros_catalogo = getCatalogo()
    registros_sede = getSedes()

    count_max = len(df.index)

    contador = 1
    for count in range(0,count_max):
        vars = df.loc[count]
        semestre = vars['semestre'].split('-')
        semestreInt = int(semestre[0])
        if(semestreInt >= 2022):
            C.Curso.count = contador
            registro = C.Curso(vars)
            key = (vars['semestre'],vars['cve_curso'])
            registros_cursos[key]=registro
            fk = 0
            try:
                fk = registros_catalogo[vars['cve_curso']].getPK()
            except:
                print("Error en curso con clave {0}".format(key))
                continue
            registros_cursos[key].setCatalogoId(fk)

            fk = 0
            fk = registros_sede[vars['Sede']].getPK()
            registros_cursos[key].setSedeId(fk)
            contador += 1

    return registros_cursos

def writeCursos():
    registros_cursos = getCursos()
    f = open(route_factories+"Cursos.csv","w",encoding='utf-8')
    for registro in registros_cursos:
        f.write(str(registros_cursos[registro]))
    f.close()