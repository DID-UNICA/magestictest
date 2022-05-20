import pandas as pd
import numpy as np

class Catalogo_Cursos:
    contador = 0

    def __init__(self,vars):
        self.pk = self.contador
        if(vars[0] == "CUCO123"):
            self.clave_curso = "COCU123"
        else:
            self.clave_curso = vars[0]
        self.clave_coordinacion = ''
        if(vars[1] == 'co'):
            self.clave_coordinacion = 2
        elif(vars[1] == 'di'):
            self.clave_coordinacion = 3
        elif(vars[1] == 'dh'):
            self.clave_coordinacion = 5
        elif(vars[1] == 'dp'):
            self.clave_coordinacion = 4
        elif(vars[1] == 'gv'):
            self.clave_coordinacion = 6
        self.nombre_curso = vars[2]
        self.tipo_curso = vars[4]
        if(self.clave_curso[2:4] == 'CU' and not (vars[4] != "" and isinstance(vars[4],str))):
            self.tipo_curso = 'Curso'
        elif(self.clave_curso[2:4] == 'CU' and (vars[4] != "" and isinstance(vars[4],str))):
            lista = {
                'Curso taller' : 'CT',
                'Curso-taller' : 'CT',
                'Curso- taller' : 'CT',
                'Curso -taller' : 'CT',
                'Curso - taller' : 'CT',
                'Curso -  taller' : 'CT',
                'Curso' : 'C',
                'Taller' : 'T',
                'Seminario' : 'S',
                'Curso en linea' : 'C',
                'Módulo de diplomado' : 'D',
                'Curso en línea' : 'C'
            }
            self.tipo_curso = lista[vars[4].capitalize()]
        if(self.clave_curso[2:4] == 'DI'):
            self.tipo_curso = 'D'          #Diplomado
        if(self.clave_curso[2:4] == 'SE'):
            self.tipo_curso = 'S'          #Seminario
        if(self.clave_curso[2:4] == 'FR'):
            self.tipo_curso = 'F'          #Foro
        if(self.clave_curso[2:4] == 'CC'):
            self.tipo_curso = 'C'           #Conferenica
        if(self.clave_curso[2:4] == 'TA'):
            self.tipo_curso = 'T'           #Taller
        self.antecedentes = vars[5]
        self.consecuentes = vars[6]
        self.fecha_disenio = vars[7]
        self.presentacion = vars[8]
        self.objetivo = vars[9]
        self.contenido = vars[10]
        self.metodologia = vars[11]
        self.duracion = vars[12]
        self.dirigido = vars[16]

    def __str__(self):
        toReturn = str(self.pk)+"|"
        if(self.clave_curso != ""and isinstance(self.clave_curso,str)):
            toReturn += self.clave_curso+"|"
        else:
            toReturn += "|"
        if(self.clave_coordinacion != "" and isinstance(self.clave_coordinacion,int)):
            toReturn += str(self.clave_coordinacion)+"|"
        else:
            toReturn += "|"
        if(self.nombre_curso != "" and isinstance(self.nombre_curso,str)):
            toReturn += self.nombre_curso+"|"
        else:
            toReturn += "|"
        if(self.tipo_curso != "" and isinstance(self.tipo_curso,str)):
            toReturn += self.tipo_curso+"|"
        else:
            toReturn += "|"
        if(self.antecedentes != "" and isinstance(self.antecedentes,str)):
            temp = self.antecedentes.split("\n")
            for val in temp:
                toReturn += val
            toReturn += "|"
        else:
            toReturn += "|"
        temp = pd.to_datetime(self.fecha_disenio, errors='coerce')
        toReturn += str(temp)+"|" if(not pd.isnull(temp)) else "|"
        if(self.objetivo != ""  and isinstance(self.objetivo,str)):
            temp = self.objetivo.split("\n")
            for val in temp:
                toReturn += val
            toReturn += "|"
        else:
            toReturn += "|"
        if(self.contenido != "" and isinstance(self.contenido,str)):
            temp = self.contenido.split("\n")
            for val in temp:
                toReturn += val
            toReturn += "|"
        else:
            toReturn += "|"
        if(self.duracion != 0):
            toReturn += str(self.duracion)+"|"
        else:
            toReturn += "|"
        if(self.dirigido != 0 and isinstance(self.dirigido,str)):
            toReturn += str(self.dirigido)
        return toReturn+"\n"
    
    def getCVECurso(self):
        return self.clave_curso

    def getNombreCurso(self):
        return self.nombre_curso
    
    def getPK(self):
        return self.pk
