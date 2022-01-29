--Unicamente se debe de cambiar la ruta, no se necesitan cambios en constraints
delete from _evaluacion_instructor_curso where id > 0;
delete from profesor_curso where id > 0;
delete from profesores_categorias where id > 0;
delete from _evaluacion_final_curso where id > 0;
delete from participante_curso where id > 0;
delete from profesors where id > 0;
copy profesors(id,nombres,apellido_paterno,apellido_materno,rfc,numero_trabajador,fecha_nacimiento,telefono,grado,abreviatura_grado,email,genero,baja,semblanza_corta,facebook,unam,procedencia,facultad_id) from 'E:\2021-2i\Profesores.csv' delimiter '|' csv;

--Unicamente se debe de cambiar la ruta, no se necesitan cambios en constraints
delete from cursos where id > 0;
delete from salons where id > 0;
copy salons(id,sede,capacidad) from 'E:\2021-2i\Sedes.csv' delimiter '#' csv;


--El constraint de Institución debe de pasar de Not Null a Null, igual con fecha_disenio, igual con tipo, igual con duración curso y cambiar la ruta
delete from catalogo_cursos where id > 0;
copy catalogo_cursos(id,clave_curso,coordinacion_id,nombre_curso,tipo,antecedentes,fecha_disenio,objetivo,contenido,duracion_curso) from 'E:\2021-2i\CatalogoCursos.csv' delimiter '|' csv;

--El constraint costo debe de cambiarse a Null, igual con la columna sgc
delete from cursos where id > 0;
copy cursos(id,semestre_anio,semestre_pi,semestre_si,fecha_inicio,fecha_fin,hora_inicio,hora_fin,dias_semana,numero_sesiones,sesiones,acreditacion,costo,cupo_maximo,cupo_minimo,fecha_envio_constancia,fecha_envio_reconocimiento,num_modulo,catalogo_id,salon_id,diplomado_id) from 'E:\2021-2i\Cursos.csv' delimiter '|' csv;

--Unicamente se debe de cambiar la ruta, no se necesitan cambios en constraints
copy participante_curso(id,acreditacion,asistencia,confirmacion,pago_curso,cancelacion,estuvo_en_lista,monto_pago,espera,causa_no_acreditacion,calificacion,contesto_hoja_evaluacion,curso_id,profesor_id) from 'E:\2021-2i\Participante_curso.csv' delimiter '|' csv;

--Unicamente se debe de cambiar la ruta, no se necesitan cambios en constraints
copy profesor_curso(id,curso_id,profesor_id,tema_seminario_id,folio_inst,folio_peque,fecha_envio) from 'E:\2021-2i\Profesor_curso.csv' delimiter ',' csv;

--Se debe de cambiar el tamaño de varchar de sug a 1500 y el de p9 a 500
copy _evaluacion_final_curso(id,p1_1,p1_2,p1_3,p1_4,p1_5,p2_1,p2_2,p2_3,p2_4,p3_1,p3_2,p3_3,p3_4,p7,p8,p9,sug,conocimiento,horarios,horarioi,participante_curso_id) from 'E:\2021-2i\Evaluacion_final_curso.csv' delimiter '|' csv;

--Unicamente se debe de cambiar la ruta, no se necesitan cambios en constraints
copy _evaluacion_instructor_curso(id,p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,participante_id,instructor_id) from 'E:\2021-2i\Evaluacion_final_instructor.csv' delimiter ',' csv;