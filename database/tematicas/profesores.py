class Profesor:
    count = 0

    def __init__(self,vars):
        self.pk = self.count 
        self.rfc = vars[4]
        self.nombres = vars[1]
        self.apellido_materno = vars[3]
        self.apellido_paterno = vars[2]
        self.numero_trabajador = vars[5]
        self.fecha_nacimiento = vars[6]
        self.telefono = vars[7]
        self.grado = vars[8]
        self.abreviatura_grado = vars[9]
        self.email = vars[10]
        self.genero = vars[11]
        self.baja = vars[12]
        self.semblanza_corta = vars[13]
        self.facebook = vars[14]
        self.unam = vars[15]
        self.procedencia = vars[16]
        self.facultad_id = ""
    
    def __str__(self):
        toReturn = str(self.pk)+"|"
        toReturn += self.nombres+"|" if(self.nombres != "") else "|"
        toReturn += self.apellido_paterno+"|" if(self.apellido_paterno != "" and isinstance(self.apellido_paterno,str)) else "|"
        toReturn += self.apellido_materno+"|" if(self.apellido_materno != "" and isinstance(self.apellido_materno,str)) else "|"
        toReturn += self.rfc+"|" if(self.rfc != ""and isinstance(self.rfc,str)) else "|"
        toReturn += str(int(float(self.numero_trabajador)))+"|" if(self.numero_trabajador != "" and self.numero_trabajador != "nan"  and isinstance(self.numero_trabajador,str)) else "|"
        toReturn += self.fecha_nacimiento+"|" if(self.fecha_nacimiento != ""and isinstance(self.fecha_nacimiento,str)) else "|"
        toReturn += str(self.telefono)+"|" if(self.telefono != 0) else "|"
        toReturn += self.grado+"|" if(self.grado != ""and isinstance(self.grado,str)) else "|"
        toReturn += self.abreviatura_grado+"|" if(self.abreviatura_grado != ""and isinstance(self.abreviatura_grado,str)) else "|"
        toReturn += self.email+"|" if(self.email != ""and isinstance(self.email,str)) else "|"
        toReturn += self.genero+"|" if(self.genero != ""and isinstance(self.genero,str)) else "|"
        toReturn += self.baja+"|" if(self.baja != ""and isinstance(self.baja,str)) else "|"
        toReturn += self.semblanza_corta+"|" if(self.semblanza_corta != ""and isinstance(self.semblanza_corta,str)) else "|"
        toReturn += self.facebook+"|" if(self.facebook != ""and isinstance(self.facebook,str)) else "|"
        toReturn += str(self.unam)+"|" 
        toReturn += self.procedencia+"|" if(self.procedencia != ""and isinstance(self.procedencia,str)) else "|"
        toReturn += self.facultad_id
        toReturn+="\n"
        return toReturn

    def getRFC(self):
        return self.rfc

    def getPK(self):
        return self.pk

    def getNombres(self):
        return self.nombres

    def getAPP(self):
        return self.apellido_paterno
    
    def getAPM(self):
        return self.apellido_materno

    def getEmail(self):
        return self.email

    def getTelefono(self):
        return self.telefono

    def correccionDatos(self):
        if(self.pk == 1163):
            self.apellido_paterno = "Díaz de León"
            self.apellido_materno = "Fernández de Castro"
            self.num_apellidos = 2
        elif(self.pk == 3521):
            self.apellido_paterno = "Ontiveros Y Sanchez"
            self.apellido_materno = "De La Barquera"
            self.num_apellidos = 2
        elif(self.pk == 623):
            self.apellido_paterno = "Buendia Servin"
            self.apellido_materno = "De La Mora"
            self.num_apellidos = 2
        elif(self.pk == 1181):
            self.apellido_paterno = "Díaz Infante"
            self.apellido_materno = "De La Mora"
            self.num_apellidos = 2
        elif(self.pk == 1182):
            self.apellido_paterno = "Díaz Infante"
            self.apellido_materno = "De La Mora"
            self.num_apellidos = 2
        elif(self.pk == 1313):
            self.apellido_paterno = "Espinoza De Los Monteros"
            self.apellido_materno = "Fernández"
            self.num_apellidos = 2
        elif(self.pk == 1422):
            self.apellido_paterno = "Fernández De Castro"
            self.apellido_materno = "P Díaz"
            self.num_apellidos = 2
        elif(self.pk == 1970):
            self.apellido_paterno = "Gutiérrez Calderón"
            self.apellido_materno = "De La Barca"
            self.num_apellidos = 2
        elif(self.pk == 4487):
            self.apellido_paterno = "Salgado"
            self.apellido_materno = "Díaz de la Vega"
            self.num_apellidos = 2
        elif(self.pk == 5056):
            self.apellido_paterno = "Vargas Espinoza"
            self.apellido_materno = "De Los Monteros"
            self.num_apellidos = 2
        elif(self.pk == 199):
            self.apellido_paterno = "Ángeles"
            self.num_apellidos = 2
        elif(self.pk == 1285):
            self.apellido_paterno = "Espejel"
            self.apellido_materno = "Espinoza"
            self.num_apellidos = 2
        elif(self.numero_trabajador == '842949'):
            self.numero_trabajador =''
        elif(self.pk == 1269):
            self.email ='lilia.andrea.escalonapicazo@gmail.com'
        elif(self.pk == 2895):
            self.email ='joshua.martinez@ingenieria.unam.edu'
        elif(self.numero_trabajador.split('.')[0] in ['850513','853026','839911','742098']):
            self.numero_trabajador = ''
        elif(self.pk == 3648):
            self.grado = 'LICENCIATURA'
            self.abreviatura_grado = 'Ing.'
        elif(self.pk == 5158):
            self.apellido_paterno = 'Del Valle'
            self.apellido_materno = 'Y Toledo'
            self.num_apellidos = 2
        elif(self.pk == 1482):
            self.apellido_paterno = 'Flores De Dios'
            self.apellido_materno = 'González'
            self.num_apellidos = 2
        elif(self.pk == 1738):
            self.apellido_paterno = 'Gallegos y Téllez'
            self.apellido_materno = 'Rojo'
            self.num_apellidos = 2
        elif(self.pk == 1825):
            self.apellido_paterno = 'Gómez De Silva'
            self.apellido_materno = 'Finkelstein'
            self.num_apellidos = 2
        elif(self.pk == 2703):
            self.apellido_paterno = 'Martín del Campo'
            self.apellido_materno = 'Alcocer'
            self.num_apellidos = 2
        elif(self.pk == 2720):
            self.apellido_paterno = 'Martínez Rivas'
            self.apellido_materno = 'Y Campomanes'
            self.num_apellidos = 2
        elif(self.pk == 3702):
            self.apellido_paterno = 'Pérez de Lara'
            self.apellido_materno = 'Domínguez'
            self.num_apellidos = 2
        elif(self.pk == 3196):
            self.apellido_paterno = 'Montes de Oca'
            self.apellido_materno = 'Huerta'
            self.num_apellidos = 2
        elif(self.pk == 3615):
            self.apellido_paterno = 'Palomino'
            self.apellido_materno = 'López Escalera'
            self.num_apellidos = 2
        elif(self.pk == 126):
            self.apellido_paterno = 'Álvarez'
            self.apellido_materno = 'Sánchez'
            self.num_apellidos = 2
        elif(self.pk == 1116):
            self.apellido_paterno = 'Cruz'
            self.apellido_materno = 'Sosa'
            self.num_apellidos = 2
        elif(self.pk == 1125):
            self.apellido_paterno = 'Cruz'
            self.apellido_materno = 'Velasco'
            self.num_apellidos = 2
        elif(self.pk == 1397):
            self.apellido_paterno = 'Fragoso'
            self.apellido_materno = 'Ruiz'
            self.num_apellidos = 2
        elif(self.pk == 2167):
            self.apellido_paterno = 'Hernández'
            self.apellido_materno = 'Mendoza'
            self.num_apellidos = 2
        elif(self.pk == 3008):
            self.apellido_paterno = 'Melgarejo'
            self.apellido_materno = 'Lomelin'
            self.num_apellidos = 2
        elif(self.pk == 3753):
            self.apellido_paterno = 'Peña'
            self.apellido_materno = 'Navarro'
            self.num_apellidos = 2
        elif(self.pk == 3806):
            self.apellido_paterno = 'Peña'
            self.apellido_materno = 'Zavala'
            self.num_apellidos = 2
        elif(self.pk == 4060):
            self.apellido_paterno = 'Reyes'
            self.apellido_materno = 'Luna'
            self.num_apellidos = 2
        elif(self.pk == 4799):
            self.apellido_paterno = 'Solís'
            self.apellido_materno = 'Flores'
            self.num_apellidos = 2
    
