--Unicamente se debe de cambiar la ruta, no se necesitan cambios en constraints
delete from _evaluacion_instructor_curso where id > 0;
delete from profesor_curso where id > 0;
delete from profesores_categorias where id > 0;
delete from _evaluacion_final_curso where id > 0;
delete from participante_curso where id > 0;
delete from profesors where id > 0;
delete from profesores_categorias where id > 0;
alter sequence profesores_categorias_id_seq restart with 1;
alter sequence catalogo_cursos_id_seq restart with 1;
alter sequence salons_id_seq restart with 1;
alter sequence profesors_id_seq restart with 1;
copy profesors(id,nombres,apellido_paterno,apellido_materno,rfc,numero_trabajador,fecha_nacimiento,telefono,grado,abreviatura_grado,email,genero,baja,semblanza_corta,facebook,unam,procedencia,facultad_id) from 'E:\CDD\migracion\Profesores.csv' delimiter '|' csv;

copy profesores_categorias(id,profesor_id,categoria_nivel_id,numero) from 'E:\CDD\migracion\Profesores_categorias.csv' csv;

--Unicamente se debe de cambiar la ruta, no se necesitan cambios en constraints
delete from cursos where id > 0;
delete from salons where id > 0;
copy salons(id,sede,capacidad) from 'E:\CDD\migracion\Sedes.csv' delimiter '#' csv;


--El constraint de Institución debe de pasar de Not Null a Null, igual con fecha_disenio, igual con tipo, igual con duración curso y cambiar la ruta
delete from catalogo_cursos where id > 0;
copy catalogo_cursos(id,clave_curso,coordinacion_id,nombre_curso,tipo,antecedentes,fecha_disenio,objetivo,contenido,duracion_curso,dirigido) from 'E:\CDD\migracion\CatalogoCursos.csv' delimiter '|' csv;

copy cursos(id,semestre_anio,semestre_pi,semestre_si,fecha_inicio,fecha_fin,hora_inicio,hora_fin,dias_semana,numero_sesiones,sesiones,acreditacion,costo,cupo_maximo,cupo_minimo,fecha_envio_constancia,fecha_envio_reconocimiento,num_modulo,catalogo_id,salon_id,diplomado_id,sgc) from 'E:\CDD\migracion\Cursos.csv' delimiter '|' csv;

copy participante_curso(id,acreditacion,asistencia,confirmacion,pago_curso,cancelacion,estuvo_en_lista,monto_pago,espera,causa_no_acreditacion,calificacion,contesto_hoja_evaluacion,curso_id,profesor_id,folio_inst) from 'E:\CDD\migracion\Participante_curso.csv' delimiter '|' csv;

copy profesor_curso(id,curso_id,profesor_id,folio_inst,tema_seminario_id,fecha_envio,fecha_exposicion) from 'E:\CDD\migracion\Profesor_curso.csv' delimiter ',' csv;

copy _evaluacion_final_curso(id, p1_1,p1_2,p1_3,p1_4,p1_5,p2_1,p2_2,p2_3,p2_4,p3_1,p3_2,p3_3,p3_4,p7,p8,p9,sug,conocimiento,horarios,horarioi,participante_curso_id) from 'E:\CDD\migracion\Evaluacion_final_curso.csv' delimiter '|' csv;

copy _evaluacion_instructor_curso(id,p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,participante_id,instructor_id) from 'E:\CDD\migracion\Evaluacion_final_instructor.csv' delimiter ',' csv;

--Cambio de las secuencias para poder agregar nuevos datos
alter sequence catalogo_cursos_id_seq restart with 785;
alter sequence salons_id_seq restart with 59;
alter sequence profesors_id_seq restart with 5546;
alter sequence cursos_id_seq restart with 47;
alter sequence participante_curso_id_seq restart with 871;
alter sequence profesor_curso_id_seq restart with 55;
alter sequence _evaluacion_final_curso_id_seq restart with 788;
alter sequence _evaluacion_instructor_curso_id_seq restart with 563;
alter sequence profesores_categorias_id_seq restart with 5546;

delete from historico_tematicas where id > 0;
copy historico_tematicas(id,nombre_curso,nombres_profesor,apellido_paterno_profesor,apellido_materno_profesor,email_profesor,telefono,tematica,semestre_anio,semestre_pi,semestre_si) from 'E:\CDD\migracion\Tematicas.csv' delimiter '|' csv;
alter sequence historico_tematicas_id_seq restart with 8480;