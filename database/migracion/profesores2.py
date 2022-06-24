import pandas as pd
class Profesor:
    count = 0

    def __init__(self,vars):
        self.pk = vars[0] 
        self.rfc = vars[4]
        self.nombres = vars[1]
        self.apellido_materno = vars[2]
        self.apellido_paterno = vars[3]
        self.numero_trabajador = vars[5]
        self.fecha_nacimiento = ""
        self.telefono = vars[7]
        self.grado = vars[8]
        self.abreviatura_grado = vars[9]
        self.email = vars[10]
        self.genero = vars[11]
        self.baja = vars[12]
        self.semblanza_corta = vars[13]
        self.facebook = vars[14]
        self.unam = float(vars[15]) if(not pd.isna(vars[15])) else 0.0
        self.procedencia = vars[16]
        self.facultad_id = vars[17]
    
    def __str__(self):
        toReturn = ""
        toReturn += str(self.pk)+"|"
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
        toReturn += str(self.facultad_id)
        toReturn+="\n"
        return toReturn

    def getRFC(self):
        return self.rfc
    
