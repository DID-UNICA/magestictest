from castCatalogoCursos import getCatalogo
from castProfesores import getProfesores
import tematica as t
import pandas as pd

def getTematicas():
    tematicas = pd.ExcelFile('../Cursossolicitados.xlsx')
    registros = tematicas.parse(0)

    registros_cursos = {}
    count = 0
    recuperado = []
    campos = registros.keys().tolist()

    registros_catalogo = getCatalogo()
    registros_profesores = getProfesores()
    registros_tematicas = []

    print(campos)

    campos_catalogo = {}
    for campo in campos:
        campos_catalogo[campo] = registros[campo]

    count_max = 0
    for row in registros.index:
        count_max += 1

    print(count_max)

    contador = 1
    elem_lista = 0
    for count in range(0,count_max):
        vars = []
        for llave in campos_catalogo:
            vars.append(campos_catalogo[llave][count])
        t.Tematica.count = contador
        registro = t.Tematica(vars)
        existe_curso = False
        for catalogo in registros_catalogo:
            if(registros_catalogo[catalogo].getCVECurso() == vars[1]):
                registro.setNombreCurso(registros_catalogo[catalogo].getNombreCurso())
                existe_curso = True
                break

        existe_profesor = False
        for profesor in registros_profesores:
            if(registros_profesores[profesor].getRFC() == vars[3]):
                registro.setDatosProfesor([registros_profesores[profesor].getNombres(),registros_profesores[profesor].getAPP(),registros_profesores[profesor].getAPM(),registros_profesores[profesor].getEmail(),registros_profesores[profesor].getTelefono()])
                if(isinstance(registros_profesores[profesor].getEmail(),str)):
                    existe_profesor = True
                break

        if(existe_profesor and existe_curso):
            registros_tematicas.append(registro)
            contador += 1
        
    return registros_tematicas

        


tematicas = getTematicas()
f = open("Tematicas.csv","w",encoding='utf-8')
for registro in tematicas:
    f.write(str(registro))
f.close()