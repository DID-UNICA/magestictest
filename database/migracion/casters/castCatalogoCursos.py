
from casters.models import catalogo_cursos as Cc
import pandas as pd
from casters import rutas
from casters.rutas import route_factories,route_excel

def getCatalogo():
    df = pd.read_excel(route_excel+'CatalogoCursos.xlsx')
    df.replace(to_replace=[r"\\t|\\n|\\r", "\t|\n|\r","_x000d_"], value=["",""," "], regex=True,inplace = True)

    registros_catalogo = {}

    count_max = len(df.index)

    for count in range(0,count_max):
        vars = df.loc[count]
        Cc.Catalogo_Cursos.contador = count+1
        registro = Cc.Catalogo_Cursos(vars)
        registros_catalogo[vars['cve_curso']]=registro
    return registros_catalogo

def writeCatalogo():
    registros_catalogo = getCatalogo()
    f = open(route_factories+"CatalogoCursos.csv","w",encoding='utf-8')
    for registro in registros_catalogo:
        f.write(str(registros_catalogo[registro]))
    f.close()