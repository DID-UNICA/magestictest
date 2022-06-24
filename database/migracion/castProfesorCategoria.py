import pandas as pd
import profesores_categorias as pc
import numpy as np
from castProfesores import getProfesores
                                                                                                                                                    #              
categorias = [np.nan,"Adm","AYTE PROF A","AYTE PROF B","FUNC","INV ASOC B TC","INV TIT A T C","INV TIT B M  T","INV TIT B T  C","INV TIT C M  T","INV TIT C TC","PROF EMERITO","PROF ASIG A","PROF ASIG B","PROF TIT A T C","PROF TIT B T C","PROF TIT C T C","TEC ASOC A T C","TEC ASOC B T C","TEC ASOC C T C","TEC AUX A T C","TEC AUX B M T","TEC AUX B T C","TEC AUX C T C","TEC TIT A T C","TEC TIT B T C","TEC TIT C T C","PROF ASO A T C","PROF ASO B M T","PROF ASO B T C","PROF ASO C M T","PROF ASO C T C","PROF ASO A M T","JUBILADO DOCENTE","JEFE DE DEPTO.","TEC AUX C M T","JEFE DE AREA","Honorarios","INV ASOC C TC","HONORARIOS  SER PRO"]

def getProfesotCategoria():
    profesores = pd.ExcelFile('../Profesores.xlsx')
    registros = profesores.parse(0)

    registros_profesor_categoria = {}
    count = 0
    campos = registros.keys().tolist()

    print("Obteniendo profesores")
    registros_profesores = getProfesores()

    campos_pc = {}
    for campo in campos:
        campos_pc[campo] = registros[campo]

    count_max = 0

    for row in registros.index:
        count_max += 1

    contador = 1

    for count in range(0,count_max):
        vars = []
        for llave in campos_pc:
            vars.append(campos_pc[llave][count])

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
        fk = -1
        for profesor in registros_profesores:
            if(registros_profesores[profesor].getRFC() == vars[0]):
                fk = profesor + 1
        if(fk != -1):
            registro.setProfesorId(fk)
            registros_profesor_categoria[count] = registro
            contador += 1

    return registros_profesor_categoria

profesores_categoria = getProfesotCategoria()
f = open("Profesores_categorias.csv","w",encoding='utf-8')
for registro in profesores_categoria:
    f.write(str(profesores_categoria[registro]))
f.close()

    