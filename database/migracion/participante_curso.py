class ParticipanteCurso:
    count = 0

    def __init__(self,vars):
        self.pk = self.count
        self.acreditacion = vars[6],
        self.asistencia = vars[5],
        self.calificacion = vars[18],
        self.confirmacion = vars[4],
        self.pago_curso = vars[8],
        self.cancelacion = vars[13],
        self.monto_pago = vars[9],
        self.causa_no_acreditacion = vars[7],
        self.estuvo_en_lista = vars[14],
        self.espera = vars[15],
        self.contesto_hoja_evaluacion = vars[16]

        #print(vars[6]+","+vars[5]+","+vars[18]+","+vars[4]+","+vars[8]+","+vars[13]+","+vars[9]+","+vars[7]+","+vars[14]+","+vars[15]+","+vars[16])
        #print(vars[18])

    def setCurso_id(self, curso_id):
        self.curso_id = curso_id

    def setProfesor_id(self, profesor_id):
        self.profesor_id = profesor_id

    def getProfesor_id(self):
        return self.profesor_id
    
    def getCurso_id(self):
        return self.curso_id

    def __str__(self):
        toReturn = ""
        toReturn = str(self.pk) + "|"
        toReturn += self.substr(self.acreditacion)+"|"if(len(str(self.acreditacion))>3) else "|"
        toReturn += self.substr(self.asistencia)+"|"if(len(str(self.acreditacion))>3) else "|"
        toReturn += self.substr(self.confirmacion)+"|"if(len(str(self.acreditacion))>3) else "|"
        toReturn += self.substr(self.pago_curso)+"|"if(len(str(self.acreditacion))>3) else "|"
        toReturn += self.substr(self.cancelacion)+"|"if(len(str(self.acreditacion))>3) else "|"
        toReturn += self.substr(self.estuvo_en_lista)+"|"if(len(str(self.acreditacion))>3) else "|"
        toReturn += self.substr(self.monto_pago)+"|"if(len(str(self.acreditacion))>3) else "|"
        toReturn += self.substr(self.espera)+"|" if(len(str(self.acreditacion))>3) else "|"
        toReturn += self.substr(self.causa_no_acreditacion)+"|" if(len(str(self.acreditacion))) else "|"
        toReturn += self.substr(self.calificacion)+"|" if(len(str(self.acreditacion))>3) else "|"
        toReturn += str(self.contesto_hoja_evaluacion)+"|"if(len(str(self.acreditacion))>3) else "|"
        toReturn += str(self.curso_id)+"|"
        toReturn += str(self.profesor_id)+"\n"
        return toReturn

    def substr(self,string):
        toReturn = str(string)[1:len(str(string))-1]
        if(toReturn[len(str(toReturn))-1] == ','):
            toReturn = toReturn[0:len(toReturn)-1]
            if(toReturn == 'nan'):
                toReturn = ''
        return toReturn
    
    def getPK(self):
        return self.pk