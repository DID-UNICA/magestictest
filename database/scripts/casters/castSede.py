from casters.models import Sede as S
import pandas as pd
from casters import rutas
from casters.rutas import route_factories,route_excel

def getSedes():
    df = pd.read_excel(route_excel+'Sedes.xlsx')

    registros_sede = {}

    count_max = len(df.index)

    for count in range(0,count_max):
        vars = df.loc[count]
        S.Sede.count = count+1
        registro = S.Sede(vars)
        registros_sede[vars[0]]=registro
    return registros_sede

def writeSedes():
    registros_sede = getSedes()
    f = open(route_factories+"Sedes.csv","w",encoding='utf-8')
    for registro in registros_sede:
        f.write(str(registros_sede[registro]))
    f.close()
