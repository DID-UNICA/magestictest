import pandas as pd
import numpy as np

class Catalogo_Cursos:
    contador = 0

    def __init__(self,vars):
        self.pk = self.contador
        if(vars['cve_curso'] == "CUCO123"):
            self.clave_curso = "COCU123"
        else:
            self.clave_curso = vars['cve_curso']
        self.clave_coordinacion = ''
        if(vars['cve_coordinación'] == 'co'):
            self.clave_coordinacion = 2
        elif(vars['cve_coordinación'] == 'di'):
            self.clave_coordinacion = 3
        elif(vars['cve_coordinación'] == 'dh'):
            self.clave_coordinacion = 5
        elif(vars['cve_coordinación'] == 'dp'):
            self.clave_coordinacion = 4
        elif(vars['cve_coordinación'] == 'gv'):
            self.clave_coordinacion = 6
        self.nombre_curso = vars['Nombre del curso']
        self.tipo_curso = vars['Tipo de Curso Diploma']
        if(self.clave_curso[2:4] == 'CU' and not (vars['Tipo de Curso Diploma'] != "" and isinstance(vars['Tipo de Curso Diploma'],str))):
            self.tipo_curso = 'Curso'
        elif(self.clave_curso[2:4] == 'CU' and (vars['Tipo de Curso Diploma'] != "" and isinstance(vars['Tipo de Curso Diploma'],str))):
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
                'Curso en línea' : 'C',
                'Microcurso' : 'C'
            }
            self.tipo_curso = lista[vars['Tipo de Curso Diploma'].capitalize()]
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
        self.antecedentes = vars['Antecedentes']
        self.consecuentes = vars['Consecuentes']
        self.fecha_disenio = vars['Fecha de diseño']
        self.presentacion = vars['Presentación']
        self.objetivo = vars['Objetivo']
        self.contenido = vars['Contenido']
        self.metodologia = vars['Metodología']
        self.duracion = vars['Duración del curso']
        self.dirigido = vars['Diseño Dirigido a:']

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
    
    def getPK(self):
        return self.pk
    
    def getNombreCurso(self):
        return self.nombre_curso
