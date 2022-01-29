class ProfesorCurso:
    count = 0

    def __init__(self,vars):
        self.pk = self.count
    
    def setCurso_id(self,curso_id):
        self.curso_id = curso_id
    
    def setProfesor_id(self,profesor_id):
        self.profesor_id = profesor_id

    def __str__(self):
        toReturn = str(self.pk)+','
        toReturn += str(self.curso_id)+','
        toReturn += str(self.profesor_id)+','+','+','+','+'\n'
        return toReturn

    def getCurso_id(self):
        return self.curso_id
    
    def getProfesor_id(self):
        return self.profesor_id