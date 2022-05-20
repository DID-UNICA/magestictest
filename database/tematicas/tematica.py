class Tematica:
    count = 0

    def __init__(self,vars):
        self.pk = self.count
        self.nombre_curso = ""
        self.nombre_profesor = ""
        self.apellido_paterno_profesor = ""
        self.apellido_materno_profesor = ""
        self.emial_profesor = ""
        self.tematica = vars[4]
        semestre = vars[0].split("-")
        self.semestre_anio = semestre[0]
        self.semestre_pi = semestre[1][0]
        self.semestre_si = semestre[1][1]

    def setDatosProfesor(self,vars):
        self.nombre_profesor = vars[0]
        self.apellido_paterno_profesor = vars[1]
        self.apellido_materno_profesor = vars[2]
        self.emial_profesor = vars[3]
        self.telefono_profesor = vars[4]

    def setNombreCurso(self,var):
        self.nombre_curso = var

    def __str__(self):
        toReturn = str(self.pk) + "|"
        toReturn += str(self.nombre_curso) +"|"
        toReturn += self.nombre_profesor +"|"
        toReturn += str(self.apellido_paterno_profesor) +"|"
        toReturn += str(self.apellido_materno_profesor) +"|"
        toReturn += str(self.emial_profesor) +"|"
        toReturn += str(self.telefono_profesor) + "|"
        toReturn += self.tematica +"|"
        toReturn += self.semestre_anio +"|"
        toReturn += self.semestre_pi +"|"
        toReturn += self.semestre_si +"|"
        toReturn += "\n"

        return toReturn