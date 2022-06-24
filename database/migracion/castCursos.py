from castCatalogoCursos import getCatalogo
import cursos as C
import pandas as pd
from castSede import getSedes

def getCursos():
    cursos = pd.ExcelFile('../Cursos.xlsx')
    registros = cursos.parse(0)

    registros_cursos = {}
    count = 0
    recuperado = []
    campos = registros.keys().tolist()

    registros_catalogo = getCatalogo()
    registros_sede = getSedes()

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
        semestre = vars[0].split('-')
        semestreInt = int(semestre[0])
        if(semestreInt >= 2022):
            C.Curso.count = contador
            registro = C.Curso(vars)
            registros_cursos[count]=registro
            fk = 0
            for catalogo in registros_catalogo:
                if(registros_catalogo[catalogo].getCVECurso() == vars[1]):
                    fk = catalogo + 1

            registros_cursos[count].setCatalogoId(fk)
            for sede in registros_sede:
                if(registros_sede[sede].getSede() == vars[3]):
                    fk = sede + 1

            registros_cursos[count].setSedeId(fk)
            contador += 1
    return registros_cursos

registros_cursos = getCursos()
f = open("Cursos.csv","w",encoding='utf-8')
for registro in registros_cursos:
    f.write(str(registros_cursos[registro]))
f.close()