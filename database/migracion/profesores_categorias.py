class Profesores_categorias:
    count = 0

    def __init__(self,categoria_nivel_id):
        self.pk = self.count
        self.categoria_nivel_id = categoria_nivel_id
        self.num = 1

    def setProfesorId(self,profesor_id):
        self.profesor_id = profesor_id
    
    def __str__(self):
        return str(self.pk)+","+str(self.profesor_id)+","+str(self.categoria_nivel_id)+","+str(self.num)+"\n"