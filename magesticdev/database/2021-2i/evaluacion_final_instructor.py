class EvaluacionFinalInstructor:
    count = 0

    def __init__(self,vars):
        self.pk = self.count
        self.p1 = vars[6]
        self.p2 = vars[7]
        self.p3 = vars[8]
        self.p4 = vars[9]
        self.p5 = vars[10]
        self.p6 = vars[11]
        self.p7 = vars[12]
        self.p8 = vars[13]
        self.p9 = vars[14]
        self.p10 = vars[15]
        self.p11 = vars[16]

    def setParticipante_id(self,participante_id):
        self.participante_id = participante_id
    
    def setInstructor_id(self,instructor_id):
        self.instructor_id = instructor_id
    
    def __str__(self):
        toReturn = str(self.pk)+","
        toReturn += str(self.p1)+","
        toReturn += str(self.p2)+","
        toReturn += str(self.p3)+","
        toReturn += str(self.p4)+","
        toReturn += str(self.p5)+","
        toReturn += str(self.p6)+","
        toReturn += str(self.p7)+","
        toReturn += str(self.p8)+","
        toReturn += str(self.p9)+","
        toReturn += str(self.p10)+","
        toReturn += str(self.p11)+","
        toReturn += str(self.participante_id)+","
        toReturn += str(self.instructor_id)
        toReturn += "\n"

        return toReturn