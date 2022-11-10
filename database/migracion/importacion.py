from casters.castCatalogoCursos import writeCatalogo
from casters.castCursos import writeCursos
from casters.castEvaluacionFinalCurso import writeEvaluacionesCurso
from casters.castEvaluacionFinalInstructor import writeEvaluacionesInstructor
from casters.castInstructorCurso import writeInstrucores
from casters.castParticipanteCurso import writeParticipantes
from casters.castProfesorCategoria import writeCategorias
from casters.castProfesores import writeProfesores
from casters.castSede import writeSedes

print('---Escribiendo los datos del catálogo de cursos---')
writeCatalogo()
print('---Escribiendo los datos de los profesores---')
writeProfesores()
print('---Escribiendo los datos de las categorias de los profesores---')
writeCategorias()
print('---Escribiendo los datos las sedes---')
writeSedes()
print('---Escribiendo los datos los cursos---')
writeCursos()
print('---Escribiendo los datos de los participantes de los cursos---')
writeParticipantes()
print('---Escribiendo los datos de los instructores de los cursos---')
writeInstrucores()
print('---Escribiendo los datos de las evaluaciones de los cursos---')
writeEvaluacionesCurso()
print('---Escribiendo los datos de las evaluaciones de los instructores---')
writeEvaluacionesInstructor()
