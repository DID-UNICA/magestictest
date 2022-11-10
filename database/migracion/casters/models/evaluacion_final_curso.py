import math

class EvaluacionFinal:

    count = 0

    def __init__(self, vars):
        self.pk = self.count,
        self.p1_1 = vars[23],
        self.p1_2 = vars[24],
        self.p1_3 = vars[25],
        self.p1_4 = vars[26],
        self.p1_5 = vars[27],
        self.p2_1 = vars[28]
        self.p2_2 = vars[29],
        self.p2_3 = vars[30],
        self.p2_4 = vars[31],
        self.p3_1 = vars[32],
        self.p3_2 = vars[33],
        self.p3_3 = vars[34],
        self.p3_4 = vars[35],
        self.p7 = vars[36],
        
        lista = []
        if(vars[38]):   
            lista.append("1")
        if(vars[39]):
            lista.append("2")
        if(vars[40]):
            lista.append("3")
        if(vars[41]):
            lista.append("4")
        self.p8 = lista
        self.p9 = vars[43],
        self.sug = vars[44]
        self.horarios = vars[48],
        self.horarioi = vars[49],
        self.participante_curso_id = vars[0]
        lista = []
        if(vars[45]):
            lista.append("1")
        if(vars[46]):
            lista.append("2")
        if(vars[47]):
            lista.append("3")
        self.conocimiento = lista
    
    def __str__(self):
        toReturn = self.substr(str(self.pk))+" |"
        toReturn += self.substr(str(self.p1_1)) + " |"
        toReturn += self.substr(str(self.p1_2)) + " |"
        toReturn += self.substr(str(self.p1_3)) + " |"
        toReturn += self.substr(str(self.p1_4)) + " |"
        toReturn += self.substr(str(self.p1_5)) + " |"
        toReturn += self.substr(str(self.p2_1)) + " |"
        toReturn += self.substr(str(self.p2_2)) + " |"
        toReturn += self.substr(str(self.p2_3)) + " |"
        toReturn += self.substr(str(self.p2_4)) + " |"
        toReturn += self.substr(str(self.p3_1)) + " |"
        toReturn += self.substr(str(self.p3_2)) + " |"
        toReturn += self.substr(str(self.p3_3)) + " |"
        toReturn += self.substr(str(self.p3_4)) + " |"
        toReturn += self.substr(str(self.p7)) + " |"
        toReturn += str(self.p8) + " |"
        string = self.substr(self.p9)
        newString = ""
        string = string.split(',')
        for val in string:
            newString += val 
        correctString = ""
        newString = newString.split('\n')
        for val in newString:
            correctString += val
        toReturn += correctString + " |"
        string = self.substr(self.sug)
        newString = ""
        string = string.split(',')
        for val in string:
            newString += val 
        correctString = ""
        newString = newString.split('\n')
        for val in newString:
            correctString += val
        toReturn += correctString + " |"
        toReturn += str(self.conocimiento) + " |"
        toReturn += self.substr(self.horarios).replace('\'','') + " |"
        toReturn += self.substr(self.horarioi).replace('\'','') + " |"
        toReturn += str(self.participante_curso_id)+"\n"

        return toReturn

    def substr(self,string):
        toReturn = str(string)
        if(toReturn[0] == '('):
            toReturn = toReturn[1:len(toReturn)]
        if(toReturn[len(toReturn)-1] == ')'):
            toReturn = toReturn[0:len(toReturn)-1]
        if(toReturn[len(toReturn)-1] == ','):
            toReturn = toReturn[0:len(toReturn)-1]
        if(toReturn == "nan"):
            toReturn = ""
        if(isinstance(string,float) and math.isnan(string)):
            toReturn = ""
        return toReturn

    def setPK(self,val):
        self.pk = val
        self.participante_curso_id = val
        if(self.participante_curso_id == 0):
            print(val)