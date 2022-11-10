import pandas as pd
from casters import rutas,castProfesores
from casters.models import profesores_categorias as pc
import numpy as np
from casters.castProfesores import getProfesores
from casters.rutas import route_factories,route_excel

categorias = [np.nan,"Adm","AYTE PROF A","AYTE PROF B","FUNC","INV ASOC B TC","INV TIT A T C","INV TIT B M  T","INV TIT B T  C","INV TIT C M  T","INV TIT C TC","PROF EMERITO","PROF ASIG A","PROF ASIG B","PROF TIT A T C","PROF TIT B T C","PROF TIT C T C","TEC ASOC A T C","TEC ASOC B T C","TEC ASOC C T C","TEC AUX A T C","TEC AUX B M T","TEC AUX B T C","TEC AUX C T C","TEC TIT A T C","TEC TIT B T C","TEC TIT C T C","PROF ASO A T C","PROF ASO B M T","PROF ASO B T C","PROF ASO C M T","PROF ASO C T C","PROF ASO A M T","JUBILADO DOCENTE","JEFE DE DEPTO.","TEC AUX C M T","JEFE DE AREA","Honorarios","INV ASOC C TC","HONORARIOS  SER PRO"]

def getProfesotCategoria():
    df = pd.read_excel(route_excel+'Profesores.xlsx')

    registros_profesor_categoria = {}
    registros_profesores = getProfesores()

    count_max = len(df.index)

    contador = 1

    for count in range(0,count_max):
        vars = df.loc[count]

        pc.Profesores_categorias.count = count+1
        temp_var = 0
        if(vars[9] == "INV TIT C T C"):
            temp_var = "INV TIT C TC"
        elif(vars[9] == "INV TIT A TC"):
            temp_var = "INV TIT A T C"
        elif(vars[9] == "INV TIT B TC" or vars[9] == "INV TIT B T C"):
            temp_var = "INV TIT B T  C"
        elif(vars[9] == "TEC TIT A TC"):
            temp_var = "TEC TIT A T C"
        elif(vars[9] == "INV ASOC B T C"):
            temp_var = "INV ASOC B TC"
        elif(vars[9] == "TEC ASOC A TC"):
            temp_var = "TEC ASOC A T C"
        elif(vars[9] == "PROF ASOC C TC"):
            temp_var = "PROF ASO C T C" 
        elif(vars[9] == "JUBILADO DOCTE"):
            temp_var = "JUBILADO DOCENTE"
        elif(vars[9] == "PROF TIT C TC"):
            temp_var = "PROF TIT C T C"
        else:
            temp_var = vars[9]
        categoria = categorias.index(temp_var)+1
        registro = pc.Profesores_categorias(categoria)
        try:
            fk = registros_profesores[vars['RFC_profesor']].getPK()
        except: 
            print("Error en profesor con RFC {0}".format(vars['RFC_profesor']))
            continue
        registro.setProfesorId(fk)
        registros_profesor_categoria[count] = registro
        contador += 1

    return registros_profesor_categoria

def writeCategorias():
    profesores_categoria = getProfesotCategoria()
    f = open(route_factories+"Profesores_categorias.csv","w",encoding='utf-8')
    for registro in profesores_categoria:
        f.write(str(profesores_categoria[registro]))
    f.close()

    