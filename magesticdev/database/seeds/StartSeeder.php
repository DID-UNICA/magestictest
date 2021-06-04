<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //USUARIOS DE PRUEBA
        DB::table('users')->insert([
            'nombres'=> 'Mauricio',
            'apellido_paterno' => 'Ramos',
            'apellido_materno' => 'Villaseñor',
            'email' => 'mauri334455@gmail.com',
            'usuario' => 'mauri334455',
            'password' => Hash::make('amores334455')
        ]);

        //SALONES DE PRUEBA COMO SEDES DE CURSOS
        DB::table('salons')->insert([
            'sede'=> 'Salon 213',
            'capacidad' => 50,
            'ubicacion' => 'FI',
        ]);
        DB::table('salons')->insert([
            'sede'=> 'Salon 321',
            'capacidad' => 50,
            'ubicacion' => 'FI',
        ]);
        DB::table('salons')->insert([
            'sede'=> 'Salon J102',
            'capacidad' => 50,
            'ubicacion' => 'FI',
        ]);
        DB::table('salons')->insert([
            'sede'=> 'Salon Y001',
            'capacidad' => 50,
            'ubicacion' => 'FI',
        ]);
        
        DB::table('salons')->insert([
          'sede'=> 'Zoom',
          'capacidad' => 50,
          'ubicacion' => 'www.zoom.com/invite/7uYvhdf',
        ]);

        DB::table('salons')->insert([
          'sede'=> 'Google Meet',
          'capacidad' => 50
        ]);
        //TABLA DE DIVISIONES DE LA FACULTAD DE INGENIERÍA
        DB::table('divisions')->insert([
            'nombre' => 'División de Ciencias Básicas',
            'abreviatura' => 'DCB'
        ]);
        
        DB::table('divisions')->insert([
          'nombre' => 'División de Ingeniería Civil y Geomática',
          'abreviatura' => 'DICyG'
        ]);

        DB::table('divisions')->insert([
            'nombre' => 'División de Ingeniería Eléctrica',
            'abreviatura' => 'DIE'
        ]);

        DB::table('divisions')->insert([
          'nombre' => 'División de Ingeniería en Ciencias de la Tierra',
          'abreviatura' => 'DICT'
        ]);

        DB::table('divisions')->insert([
          'nombre' => 'División de Ingeniería Mecánica e Industrial',
          'abreviatura' => 'DIMEI'
        ]);

        DB::table('divisions')->insert([
            'nombre' => 'División de Ciencias Sociales y Humanidades',
            'abreviatura' => 'DCSyH'
        ]);

        DB::table('divisions')->insert([
          'nombre' => 'División de Educación Continua y a Distancia',
          'abreviatura' => 'DECD'
        ]);

        DB::table('divisions')->insert([
          'nombre' => 'Becarios',
          'abreviatura' => 'Becarios'
        ]);

        DB::table('divisions')->insert([
          'nombre' => 'Servicio social',
          'abreviatura' => 'Servicio social'
        ]);

        DB::table('divisions')->insert([
          'nombre' => 'Externo',
          'abreviatura' => 'Externo',
        ]);

        DB::table('divisions')->insert([
            'nombre' => 'Secretarías',
            'abreviatura' => 'Secretarías'
          ]);

        //TABLA DE FACULTADES DE LA UNAM
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Arquitectura'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Artes y Diseño'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Ciencias'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Ciencias Políticas y Sociales'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Contaduría y Administración'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Derecho'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Economía'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Estudios Superiores (FES) Acatlán'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Estudios Superiores (FES) Aragón'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Estudios Superiores (FES) Cuautitlán'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Estudios Superiores (FES) Iztacala'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Estudios Superiores (FES) Zaragoza'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Filosofía y Letras'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Ingeniería'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Medicina'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Medicina Veterinaria y Zootecnia'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Música'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Odontología'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Psicología'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Facultad de Química'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Centro de Física Aplicada y Tecnología Avanzada'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Instituo de Energías Renovables'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Centro de Nanociencias y Nanotecnología'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Escuela Nacional de Estudios Superiores,Unidad Mérida'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Escuela Nacional de Estudios Superiores,Unidad Morelia'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Instituto de Investigaciones en Matemáticas y en Sistemas'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Escuela Nacional de Enfermería y Obstetricia'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Escuela Nacional de Estudios Superiores, Unidad León'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Centro de Ciencias Genómicas'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Escuela Nacional de Estudios Superiores, Unidad Juriquilla'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Escuela Nacional de Trabajo Social'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Centro Universitarios de Estudios Cinematográficos'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Centro Universitario de Teatro'
        ]);
        DB:: table('facultads')->insert([
            'nombre' =>'Escuela Nacional de Lenguas, Lingúistica y Traducción'
        ]);

        //TABLA DE CARRERAS DE LA FACULTAD DE INGENIERÍA
        DB::table('carreras')->insert([
          'nombre' => 'Ingeniería Aeroespacial',
          'clave' => 107
        ]);

        DB::table('carreras')->insert([
            'nombre' => 'Ingeniería Civil',
            'clave' => 107
        ]);

        DB::table('carreras')->insert([
          'nombre' => 'Ingeniería Geomática',
          'clave' => 107
        ]);

        DB::table('carreras')->insert([
          'nombre' => 'Ingeniería Ambiental',
          'clave' => 107
        ]);

        DB::table('carreras')->insert([
          'nombre' => 'Ingeniería Eléctrica y Eletrónica',
          'clave' => 109
        ]);

        DB::table('carreras')->insert([
          'nombre' => 'Ingeniería de Minas y Metalurgía',
          'clave' => 108
        ]);

        DB::table('carreras')->insert([
          'nombre' => 'Ingeniería en Computación',
          'clave' => 110
        ]);
        
        DB::table('carreras')->insert([
          'nombre' => 'Ingeniería en Telecomunicaciones',
          'clave' => 111
        ]);
        
        DB::table('carreras')->insert([
          'nombre' => 'Ingeniería Geofísica',
          'clave' => 112
        ]);
        
        DB::table('carreras')->insert([
          'nombre' => 'Ingeniería Geológica',
          'clave' => 113
        ]);
        
        DB::table('carreras')->insert([
          'nombre' => 'Ingeniería Industrial',
          'clave' => 114
        ]);
        
        DB::table('carreras')->insert([
          'nombre' => 'Ingeniería Mecánica',
          'clave' => 115
        ]);
      
        DB::table('carreras')->insert([
          'nombre' => 'Ingeniería Mecatrónica',
          'clave' => 116
        ]);
        
        DB::table('carreras')->insert([
          'nombre' => 'Ingeniería Petrolera',
          'clave' => 117
        ]);

        DB::table('carreras')->insert([
          'nombre' => 'Ingenieria en Sistemas Biomédicos',
          'clave' => 1231
        ]);

        //TABLA DE CATEGORÍAS Y NIVELES DEL PROFESOR
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Ninguna', 'abreviatura' => ''
        ]);
        
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Administrativo', 'abreviatura' => 'Adm'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Ayudante de profesor A', 'abreviatura' => 'AYTE PROF A'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Ayudante de profesor B', 'abreviatura' => 'AYTE PROF B'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Funcionario', 'abreviatura' => 'FUNC'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Investigador Asociado B TC', 'abreviatura' => 'INV ASOC B TC'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Investigador titular A TC', 'abreviatura' => 'INV TIT A T C'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Investigador titular B MT', 'abreviatura' => 'INV TIT B M  T'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Investigador titular B TC', 'abreviatura' => 'INV TIT B T  C'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Investigador titular C MT', 'abreviatura' => 'INV TIT C M  T'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Investigador titular C TC', 'abreviatura' => 'INV TIT C T  C'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Profesor Emérito', 'abreviatura' => 'PROF EMERITO'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Profesor de Asignatura A', 'abreviatura' => 'PROF ASG A'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Profesor de Asignatura B', 'abreviatura' => 'PROF ASG B'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Profesor Titular A TC', 'abreviatura' => 'PROF TIT A T C'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Profesor Titular B TC', 'abreviatura' => 'PROF TIT B T C'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Profesor Titular C TC', 'abreviatura' => 'PROF TIT C T C'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Técnico Asociado A TC', 'abreviatura' => 'TEC ASOC A T C'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Técnico Asociado B TC', 'abreviatura' => 'TEC ASOC B T C'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Técnico Asociado C TC', 'abreviatura' => 'TEC ASOC C T C'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Técnico Auxiliar A TC', 'abreviatura' => 'TEC AUX A T C'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Técnico Auxiliar B MT', 'abreviatura' => 'TEC AUX B M T'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Técnico Auxiliar B TC', 'abreviatura' => 'TEC AUX B T C'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Técnico Auxiliar C TC', 'abreviatura' => 'TEC AUX C T C'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Técnico Titular A TC', 'abreviatura' => 'TEC TIT A T C'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Técnico Titular B TC', 'abreviatura' => 'TEC TIT B T C'
        ]);
        DB::table('categoria_nivel')->insert([
          'categoria' => 'Técnico Titular C TC', 'abreviatura' => 'TEC TIT C T C'
        ]);
				DB::table('categoria_nivel')->insert([
          'categoria' => 'Secretarias', 'abreviatura' => 'Secretarias'
        ]);
				DB::table('categoria_nivel')->insert([
          'categoria' => 'Becarios', 'abreviatura' => 'Becarios'
        ]);
				DB::table('categoria_nivel')->insert([
          'categoria' => 'Externos', 'abreviatura' => 'Externos'
        ]);
        

        //TABLA DE PROFESORES DE PRUEBA
        DB::table('profesors')->insert([
            'nombres' => 'Juan',
            'apellido_paterno' => 'Ramirez',
            'apellido_materno' => 'Gonzales',
            'rfc' => 'RAGJ720101T72',
            'numero_trabajador' => '12143231',
            'categoria_nivel_id'=>1,
            'fecha_nacimiento' => '1972-01-01',
            'telefono' => '55664487',
            'grado' => 'Maestría',
            'abreviatura_grado' => 'Mtro.',
            'email' => 'carosiim.sdco@gmail.com',
            'semblanza_corta'=> 'Arquitecto con especialidad en paisajismo. Actualmente está creando su propia consultura.
Sus grados profesionales son:
  - Doctora en Ciencias de la Educación por el Colegio de Posgrado de la Ciudad de México.
  - Maestra en Educación Superior por la Facultad de Filosofía y Letras de la UNAM.
  - Licenciada en Pedagogía por la Universidad Pedagógica Nacional.
Está Diplomada en: 
  - Aplicaciones de las TIC para la Enseñanza por la Facultad de Ingeniería y la 
  Dirección General de Cómputo y Tecnologías de la Información y la Comunicació
  de la UNAM. Docencia por la División de Educación Continua de la Facultad de 
  Filosofía y Letras de la UNAM.
  - Producción y Comprensión Lingüística por la Casa de las Humanidades de la UNAM.
Está Certificada en:
  - La Impartición de Cursos Presenciales por el Organismo Gubernamental CONOCER de SEP.
    - Como Auditora Interna Nivel 2 en los Sistemas de Gestión de la Calidad, sobre la
    base de la NORMA ISO 9001;2000 y bajo las directrices de ISO 9011;2002 por el
  Organismo de Enlace Liasion INLAC a ISOITC176.
    - Como Auditora Interna por la Coordinación de la Investigación Científica de la UNAM.
    Ha cursado: 68 cursos, talleres y seminarios en temas de formación docente, didáctica,
    evaluación y comunicación.
    Ha impartido 102 cursos, talleres y seminarios para profesores. En temas de formación
    docente y área didáctico pedagógica. Es profesora de asignatura desde 1994 en las
    asignaturas de "Técnicas para el estudio" en el semestre propedéutico y en "Cultura
    y comunicación" de primer semestre. Es asesora psicopedagógica en COPADI Tutora y 
    sinodal del Posgrado de MADEMS-UNAM. A participado como ponente en Congresos 
    Nacionales e Internacionales de Educación, Enseñanza de la Ingeniería, Formación 
    Docente y pedagogía desde el nivel educativo inicial. Medio superior y superior. 
    Publicaciones en Colaboración: Programas y Manuales Psicopedagógicos para la atención
    de niños de O a 6 años en los Centros de Desarrollo Infantil Derechos Reservados. 
    SEP. Registro Derechos de Autor 14091981 222/81 Agosto 1981. 
Está Diplomada en: 
  - Aplicaciones de las TIC para la Enseñanza por la Facultad de Ingeniería y la 
  Dirección General de Cómputo y Tecnologías de la Información y la Comunicación de la 
  UNAM. Docencia por la División de Educación Continua de la Facultad de Filosofía y 
  Letras de la UNAM.
  - Producción y Comprensión Lingüística por la Casa de las Humanidades de la UNAM. 
Está Certificada en:
  - La Impartición de Cursos Presenciales por el Organismo Gubernamental CONOCER de SEP. 
    - Como Auditora Interna Nivel 2 en los Sistemas de Gestión de la Calidad, sobre la
    base de la NORMA ISO 9001;2000 y bajo las directrices de ISO 9011;2002 por el 
    Organismo de Enlace Liasion INLAC a ISOITC176.',
            'genero' => 'masculino',
            'facebook' => 'Juan Ramirez',
            'unam' => false,
            'procedencia'=> 'Universidad Miskatonic'

        ]);
        DB::table('profesors')->insert([
            'nombres' => 'Marta',
            'apellido_paterno' => 'Suarez',
            'apellido_materno' => 'Prados',
            'rfc' => 'SUPM720101D11',
            'numero_trabajador' => '12143232',
            'categoria_nivel_id'=>1,
            'fecha_nacimiento' => '1972-01-01',
            'telefono' => '557458963',
            'grado' => 'Licenciatura',
            'abreviatura_grado' => 'Lic.',
            'email' => 'MSP@gmail.com',
            'semblanza_corta' => 'Profesora de la facultad de ingeniería, fundó la asociación de mujeres programadoras con
el fin de impulsar los derechos y la presencia de la mujer en el ámbito profesional de
las Tecnologías de la Información. Es egresada de la Facultad de Ciencias. Doctora en
análisis de datos.',
            'genero' => 'femenino',
            'facebook' => 'Martha Suarez',
            'unam' => true,
            'facultad_id' =>1

        ]);
        DB::table('profesors')->insert([
            'nombres' => 'Santiago',
            'apellido_paterno' => 'Hernández',
            'apellido_materno' => 'Gonzales',
            'rfc' => 'HEGS720517RJ3',
            'numero_trabajador' => '12143233',
            'categoria_nivel_id'=>1,
            'fecha_nacimiento' => '1972-05-17',
            'telefono' => '55664487',
            'grado' => 'Ingeniería',
            'abreviatura_grado' => 'Ing.',
            'email' => 'prof2@gmail.com',
            'semblanza_corta' => 'Ingeniero geofisico, con especilidad en volcanes y terremotos y maestria en rocas.',
            'genero' => 'masculino',
            'facebook' => 'face',
            'unam' => true,
            'facultad_id' =>14

        ]);
        DB::table('profesors')->insert([
            'nombres' => 'Melina',
            'apellido_paterno' => 'Pelcastre',
            'apellido_materno' => 'Prados',
            'rfc' => 'PEPM720517IW2',
            'numero_trabajador' => '12143234',
            'categoria_nivel_id'=>1,
            'fecha_nacimiento' => '1972-05-017',
            'telefono' => '557458963',
            'grado' => 'Licenciatura',
            'abreviatura_grado' => 'Lic.',
            'email' => 'MSP2@gmail.com',
            'semblanza_corta' => 'Licenciada en administracion egresada de la FCyA de la UNAM con honores.',
            'genero' => 'femenino',
            'facebook' => 'MyFace',
            'unam' => true,
            'facultad_id' =>5

        ]);
        DB::table('profesors')->insert([
            'nombres' => 'Mateo',
            'apellido_paterno' => 'Juarez',
            'apellido_materno' => 'Fernández',
            'rfc' => 'JUFM720101M74',
            'numero_trabajador' => '12143235',
            'categoria_nivel_id'=>5,
            'fecha_nacimiento' => '1972-01-01',
            'telefono' => '55664487',
            'grado' => 'Licenciatura',
            'abreviatura_grado' => 'Lic.',
            'email' => 'prof3@gmail.com',
            'semblanza_corta' => 'Ingeniero mecanico con especialidad en diseño mecanico egresado de la unam y con
maestria en Alemania.',
            'genero' => 'masculino',
            'facebook' => 'Mateo Juarez',
            'unam' => true,
            'facultad_id' =>14

        ]);
        DB::table('profesors')->insert([
            'nombres' => 'Gabriela',
            'apellido_paterno' => 'González',
            'apellido_materno' => 'Velázquez',
            'rfc' => 'GOVG720101FZ6',
            'numero_trabajador' => '12143236',
            'categoria_nivel_id'=>1,
            'fecha_nacimiento' => '1972-01-01',
            'telefono' => '557458963',
            'grado' => 'Doctorado',
            'abreviatura_grado' => 'Dra.',
            'email' => 'MSP3@gmail.com',
            'semblanza_corta' => 'Ingeniera industrial, con un MBA en inglaterra y tambien trabaja en Coca Cola.',
            'genero' => 'femenino',
            'facebook' => 'Gaby Gonzalez',
            'unam' => true,
            'facultad_id' =>14
        ]);
        DB::table('profesors')->insert([
            'nombres' => 'Luis Daniel',
            'apellido_paterno' => 'Velásquez',
            'apellido_materno' => 'Velázquez',
            'rfc' => 'VEVL720101T65',
            'numero_trabajador' => '12143237',
            'categoria_nivel_id'=>7,
            'fecha_nacimiento' => '1972-01-01',
            'telefono' => '55664487',
            'grado' => 'Maestría',
            'abreviatura_grado' => 'Mtro.',
            'email' => 'prof4@gmail.com',
            'semblanza_corta' => 'Ingeniero en telecomunicaciones y estudia actualmente su segunda carrera, en economia.',
            'genero' => 'masculino',
            'facebook' => 'Dani Velásquez',
            'unam' => true,
            'facultad_id' =>14
        ]);
        DB::table('profesors')->insert([
            'nombres' => 'Fernanda',
            'apellido_paterno' => 'Núñez',
            'apellido_materno' => 'Sandoval',
            'rfc' => 'NUSF720101I63',
            'numero_trabajador' => '12143238',
            'categoria_nivel_id'=>1,
            'fecha_nacimiento' => '1972-01-01',
            'telefono' => '557458963',
            'grado' => 'Maestría',
            'abreviatura_grado' => 'Mtra.',
            'email' => 'MSP4@gmail.com',
            'semblanza_corta' => 'Ingeniera civil, maestria en puentes y con especialidad en puentes muy grandes.',
            'genero' => 'femenino',
            'facebook' => 'Fer Sandoval',
            'unam' => true,
            'facultad_id' =>14

        ]);
        DB::table('profesors')->insert([
            'nombres' => 'Ángel',
            'apellido_paterno' => 'García',
            'apellido_materno' => 'Casares',
            'rfc' => 'GACA720101EL4',
            'numero_trabajador' => '12143239',
            'categoria_nivel_id'=>11,
            'fecha_nacimiento' => '1972-01-01',
            'telefono' => '55664487',
            'grado' => 'Maestría',
            'abreviatura_grado' => 'Mtro.',
            'email' => 'prof5@gmail.com',
            'semblanza_corta' => 'Ingeniero petrolero, actualmente se desempeña tambien en cargos altos en PEMEX',
            'genero' => 'masculino',
            'facebook' => 'Angel García Caseres',
            'unam' => true,
            'facultad_id' =>14
        ]);
        DB::table('profesors')->insert([
            'nombres' => 'Vivian',
            'apellido_paterno' => 'Salcedo',
            'apellido_materno' => 'Víquez',
            'rfc' => 'SAVV720101RV2',
            'numero_trabajador' => '12143240',
            'categoria_nivel_id'=>4,
            'fecha_nacimiento' => '1972-01-01',
            'telefono' => '557458963',
            'grado' => 'Maestría',
            'abreviatura_grado' => 'Mtra.',
            'email' => 'MSP5@gmail.com',
            'semblanza_corta' => 'Licenciada en contaduria, con maestria en impuestos empresariales y doctorado en 
contaduria para Macroempresas.',
            'genero' => 'femenino',
            'facebook' => 'Vivi Salcedo',
            'unam' => true,
            'facultad_id' =>5
        ]);


        DB::table('profesors')->insert([
            'nombres' => 'Arturo',
            'apellido_paterno' => 'Galván',
            'apellido_materno' => 'Argote',
            'rfc' => 'GAAA720101HY0',
            'numero_trabajador' => '12143241',
            'categoria_nivel_id'=>5,
            'fecha_nacimiento' => '1972-01-01',
            'telefono' => '55664487',
            'grado' => 'Maestría',
            'abreviatura_grado' => 'Mtro.',
            'email' => 'prof6@gmail.com',
            'semblanza_corta' => 'Arquitecto con especialidad en paisajismo. Actualmente está creando su propia consultura',
            'genero' => 'masculino',
            'facebook' => 'Arturo Galvan',
            'unam' => true,
            'facultad_id' =>1

        ]);
        DB::table('profesors')->insert([
            'nombres' => 'Melissa',
            'apellido_paterno' => 'Valles',
            'apellido_materno' => 'Hernández',
            'rfc' => 'VAHM720101Q41',
            'numero_trabajador' => '12143242',
            'categoria_nivel_id'=>1,
            'fecha_nacimiento' => '1972-01-01',
            'telefono' => '557458963',
            'grado' => 'Maestría',
            'abreviatura_grado' => 'Mtra.',
            'email' => 'MSP6@gmail.com',
            'semblanza_corta' => 'Licenciada en arquitectura con maestria en diseño de interiores ',
            'genero' => 'femenino',
            'facebook' => 'Melissaa Valles',
            'unam' => true,
            'facultad_id' =>1

        ]);
        DB::table('profesors')->insert([
            'nombres' => 'Roberto',
            'apellido_paterno' => 'Sánchez',
            'apellido_materno' => 'Gonzales',
            'rfc' => 'SAGR720101JR0',
            'numero_trabajador' => '12143243',
            'categoria_nivel_id'=>1,
            'fecha_nacimiento' => '1972-01-01',
            'telefono' => '55664487',
            'grado' => 'Maestría',
            'abreviatura_grado' => 'Mtro.',
            'email' => 'prof7@gmail.com',
            'semblanza_corta' => 'Ingeniero en Minas, con especialidad en minas de carbon y diamante.',
            'genero' => 'masculino',
            'facebook' => 'Roberto Sanchez',
            'unam' => true,
            'facultad_id' =>14

        ]);
        DB::table('profesors')->insert([
            'nombres' => 'Daniela',
            'apellido_paterno' => 'Arjona',
            'apellido_materno' => 'Valle',
            'rfc' => 'AOVD720101DQ6',
            'numero_trabajador' => '12143244',
            'categoria_nivel_id'=>1,
            'fecha_nacimiento' => '1972-05-017',
            'telefono' => '557458963',
            'grado' => 'Maestría',
            'abreviatura_grado' => 'Mtra.',
            'email' => 'MSP7@gmail.com',
            'semblanza_corta' => 'Ingeniera en Sistemas Biómedicos, egresada del ITAM',
            'genero' => 'femenino',
            'facebook' => 'Dani Arjona',
            'unam' => true,
            'facultad_id' =>5

        ]);
        DB::table('profesors')->insert([
            'nombres' => 'Alejandro',
            'apellido_paterno' => 'López',
            'apellido_materno' => 'Mateos',
            'rfc' => 'LOMA720101EU3',
            'numero_trabajador' => '12143245',
            'categoria_nivel_id'=>5,
            'fecha_nacimiento' => '1972-01-01',
            'telefono' => '55664487',
            'grado' => 'Maestría',
            'abreviatura_grado' => 'Mtro.',
            'email' => 'prof8@gmail.com',
            'semblanza_corta' => 'Ingeniero mecanico con especialidad en termofluidos actualmente trabaja para Ferrari.',
            'genero' => 'masculino',
            'facebook' => 'Alex López Mateos',
            'unam' => true,
            'facultad_id' =>14

        ]);
        DB::table('profesors')->insert([
            'nombres' => 'Julia',
            'apellido_paterno' => 'Domínguez',
            'apellido_materno' => 'Méndez',
            'rfc' => 'DOMJ7201011Q9',
            'numero_trabajador' => '12143246',
            'categoria_nivel_id'=>1,
            'fecha_nacimiento' => '1972-01-01',
            'telefono' => '557458963',
            'grado' => 'Maestría',
            'abreviatura_grado' => 'Mtra.',
            'email' => 'MSP8@gmail.com',
            'semblanza_corta' => 'Ingeniera insdustrial enfocada al area de logistica con maestry en cadena de suministros
en Canada.',
            'genero' => 'femenino',
            'facebook' => 'Julia Dominguez',
            'unam' => true,
            'facultad_id' =>14
        ]);
        DB::table('profesors')->insert([
            'nombres' => 'Luis Fernando',
            'apellido_paterno' => 'Méndez',
            'apellido_materno' => 'Vallesteros',
            'rfc' => 'MEVL720101GV4',
            'numero_trabajador' => '12143247',
            'categoria_nivel_id'=>7,
            'fecha_nacimiento' => '1972-01-01',
            'telefono' => '55664487',
            'grado' => 'Maestría',
            'abreviatura_grado' => 'Mtro.',
            'email' => 'prof9@gmail.com',
            'semblanza_corta' => 'Ingeniero en telecomunicaciones que trabaja con la super computadora de la UNAM',
            'genero' => 'masculino',
            'facebook' => 'Luis Méndez',
            'unam' => true,
            'facultad_id' =>14
        ]);
        DB::table('profesors')->insert([
            'nombres' => 'Hilda',
            'apellido_paterno' => 'Ramírez',
            'apellido_materno' => 'Ramírez',
            'rfc' => 'RARH720101DMA',
            'numero_trabajador' => '12143248',
            'categoria_nivel_id'=>1,
            'fecha_nacimiento' => '1972-01-01',
            'telefono' => '557458963',
            'grado' => 'Maestría',
            'abreviatura_grado' => 'Mtra.',
            'email' => 'MSP9@gmail.com',
            'semblanza_corta' => 'Ingeniera civil, socia de Carlos Slim y con maestria en carreteras',
            'genero' => 'femenino',
            'facebook' => 'Hilda Ramirez',
            'unam' => true,
            'facultad_id' =>14

        ]);
        DB::table('profesors')->insert([
            'nombres' => 'Juan',
            'apellido_paterno' => 'Macedo',
            'apellido_materno' => 'Jiménez',
            'rfc' => 'MAJJ720101GF7',
            'numero_trabajador' => '12143249',
            'categoria_nivel_id'=>11,
            'fecha_nacimiento' => '1972-01-01',
            'telefono' => '55664487',
            'grado' => 'Maestría',
            'abreviatura_grado' => 'Mtro.',
            'email' => 'prof10@gmail.com',
            'semblanza_corta' => 'Ingeniero petrolero, trabaja en paises arabes y es de los hombres más ricos del mundo',
            'genero' => 'masculino',
            'facebook' => 'Juan Macedo',
            'unam' => true,
            'facultad_id' =>14
        ]);
        DB::table('profesors')->insert([
            'nombres' => 'Viridiana',
            'apellido_paterno' => 'Valencia',
            'apellido_materno' => 'Manso',
            'rfc' => 'VAMV720101HZA',
            'numero_trabajador' => '12143250',
            'categoria_nivel_id'=>4,
            'fecha_nacimiento' => '1972-01-01',
            'telefono' => '557458963',
            'grado' => 'Maestría',
            'abreviatura_grado' => 'Mtra.',
            'email' => 'MSP10@gmail.com',
            'semblanza_corta' => 'Licenciada en contaduria, ella calcula los imppuestos de la unam y tiene maestría
en impuestos universitarios.',
            'genero' => 'femenino',
            'facebook' => 'Viridiana Valencia',
            'unam' => true,
            'facultad_id' =>5
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Gabriel',
          'apellido_paterno'=>'Lopez',
          'apellido_materno'=>'Dominguez',
          'rfc'=>'LODG720202LODG',
          'numero_trabajador' => '121432492',
          'fecha_nacimiento'=>'1972-02-02'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Guillermo Adolfo',
          'apellido_paterno'=>'Vignau',
          'apellido_materno'=>'Esteva',
          'rfc'=>'VIEG720203VIEG',
          'numero_trabajador' => '121432493',
          'fecha_nacimiento'=>'1972-02-03'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Guillermo Gabriel',
          'apellido_paterno'=>'Aguilar',
          'apellido_materno'=>'Lacavex',
          'rfc'=>'AGLG740101AGLG',
          'numero_trabajador' => '1214324500',
          'fecha_nacimiento'=>'1974-01-01'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Victorino',
          'apellido_paterno'=>'Garcia',
          'apellido_materno'=>'Ramos',
          'rfc'=>'GARV740102GARV',
          'numero_trabajador' => '1214324501',
          'fecha_nacimiento'=>'1974-01-02'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Luis Bruno',
          'apellido_paterno'=>'Garduño',
          'apellido_materno'=>'Castro',
          'rfc'=>'GACL740103GACL',
          'numero_trabajador' => '1214324502',
          'fecha_nacimiento'=>'1974-01-03'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Manuel',
          'apellido_paterno'=>'Hernandez',
          'apellido_materno'=>'Gonzalez',
          'rfc'=>'HEGM740105HEGM',
          'numero_trabajador' => '1214324504',
          'fecha_nacimiento'=>'1974-01-05'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Julieta',
          'apellido_paterno'=>'Mares',
          'apellido_materno'=>'Lopez',
          'rfc'=>'MALJ740106MALJ',
          'numero_trabajador' => '1214324505',
          'fecha_nacimiento'=>'1974-01-06'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Jacquelyn',
          'apellido_paterno'=>'Martinez',
          'apellido_materno'=>'Alvarez',
          'rfc'=>'MAAJ740107MAAJ',
          'numero_trabajador' => '1214324506',
          'fecha_nacimiento'=>'1974-01-07'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Luis Enrique',
          'apellido_paterno'=>'Quintanar',
          'apellido_materno'=>'Cortes',
          'rfc'=>'QUCL740108QUCL',
          'numero_trabajador' => '1214324507',
          'fecha_nacimiento'=>'1974-01-08'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Israel',
          'apellido_paterno'=>'Rios',
          'apellido_materno'=>'Mora',
          'rfc'=>'RIMI740109RIMI',
          'numero_trabajador' => '1214324508',
          'fecha_nacimiento'=>'1974-01-09'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Servando',
          'apellido_paterno'=>'Ruiz',
          'apellido_materno'=>'Rodriguez',
          'rfc'=>'RURS740109RURS',
          'numero_trabajador' => '1214324509',
          'fecha_nacimiento'=>'1974-01-09'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Norma Isela',
          'apellido_paterno'=>'Vega',
          'apellido_materno'=>'Deloya',
          'rfc'=>'VEDM740110VEDM',
          'numero_trabajador' => '1214324510',
          'fecha_nacimiento'=>'1974-01-10'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Voileta Erendira',
          'apellido_paterno'=>'Escalante',
          'apellido_materno'=>'Estrada',
          'rfc'=>'EEEV720102EEE',
          'numero_trabajador' => '121432450',
          'fecha_nacimiento'=>'1972-01-02'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Jose',
          'apellido_paterno'=>'Gonzalez',
          'apellido_materno'=>'Suarez',
          'rfc'=>'GOSJ720103GOSJ',
          'numero_trabajador' => '121432451',
          'fecha_nacimiento'=>'1972-01-03'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Patricia',
          'apellido_paterno'=>'Gonzalez',
          'apellido_materno'=>'Vega',
          'rfc'=>'GOPV720104GOPV',
          'numero_trabajador' => '121432452',
          'fecha_nacimiento'=>'1972-01-04'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Gudelia',
          'apellido_paterno'=>'Hernandez',
          'apellido_materno'=>'Molina',
          'rfc'=>'HEMG720105HEMG',
          'numero_trabajador' => '121432453',
          'fecha_nacimiento'=>'1972-01-05'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Jose Gerardo',
          'apellido_paterno'=>'Lopez',
          'apellido_materno'=>'Bonifacio',
          'rfc'=>'LOBJ720106LOBJ',
          'numero_trabajador' => '121432454',
          'fecha_nacimiento'=>'1972-01-06'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Martin',
          'apellido_paterno'=>'Mejia',
          'apellido_materno'=>'Ramos',
          'rfc'=>'MERM720107MERM',
          'numero_trabajador' => '121432455',
          'fecha_nacimiento'=>'1972-01-07'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Javier',
          'apellido_paterno'=>'Millan',
          'apellido_materno'=>'Martinez',
          'rfc'=>'MIMJ720108MIMJ',
          'numero_trabajador' => '121432456',
          'fecha_nacimiento'=>'1972-01-08'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Eduardo',
          'apellido_paterno'=>'Rosas',
          'apellido_materno'=>'Lira',
          'rfc'=>'ROLE720109ROLE',
          'numero_trabajador' => '121432457',
          'fecha_nacimiento'=>'1972-01-09'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Agustin Gerardo',
          'apellido_paterno'=>'Ruiz',
          'apellido_materno'=>'Tamayo',
          'rfc'=>'RUTA720111RUTA',
          'numero_trabajador' => '121432458',
          'fecha_nacimiento'=>'1972-01-11'
        ]);

        DB::table('profesors')->insert([
          'nombres'=>'Jaime Juan',
          'apellido_paterno'=>'Zarza y',
          'apellido_materno'=>'Teran',
          'rfc'=>'ZATJ720112ZATJ',
          'numero_trabajador' => '121432459',
          'fecha_nacimiento'=>'1972-01-12'
        ]);

        //COORDINACIONES DEL CENTRO DE DOCENCIA, COORDINADORES DE PRUEBA
        DB::table('coordinacions')->insert([
          'abreviatura'=>'CO',
          'nombre_coordinacion'=>'Área de Cómputo',
          'coordinador'=>'Daniela Lopez Gomez',
          'grado'=>'M.C.C',
          'usuario'=>'daniela',
          'password'=> Hash::make('1234')
        ]);
    
        DB::table('coordinacions')->insert([
          'abreviatura'=>'DI',
          'nombre_coordinacion'=>'Área Disciplinar e Investigación Educativa',
          'coordinador'=>'Roman Dominguez Perez',
          'grado'=>'M.E.M.',
          'usuario'=>'roman',
          'password'=> Hash::make('1234')
        ]);
        
        DB::table('coordinacions')->insert([
          'nombre_coordinacion' => 'Área Didáctico Pedagógica',
          'abreviatura' => 'DP',
          'coordinador' => 'Daniel Morales',
          'grado' => 'M.E.M.',
          'usuario' => 'daniel',
          'password' => Hash::make('1234'),
        ]);
    
        DB::table('coordinacions')->insert([
          'nombre_coordinacion' => 'Área de Desarrollo Humano',
          'abreviatura' => 'DH',
          'coordinador' => 'Jacob Hernandez',
          'grado' => 'M.E.M.',
          'usuario' => 'jacob',
          'password' => Hash::make('1234'),
      ]);
			
			DB::table('coordinacions')->insert([
				'nombre_coordinacion' => 'Área de Gestión y Vinculación',
				'abreviatura' => 'GV',
				'coordinador' => 'Jorge Luis Morales',
				'grado' => 'M.E.M.',
				'usuario' => 'jorge',
				'password' => Hash::make('1234'),
		]);

      //CATÁLOGO DE CURSOS DE PRUEBA
        DB::table('catalogo_cursos')->insert([
            'nombre_curso' =>'Programacion Estructurada',
            'duracion_curso' => '10',
            'coordinacion_id' => 1,
            'tipo' => 'CT',
            'institucion' => 'CDD',
            'dirigido' => 'Personas interesadas en el área de la programación, desarrollo de software
y tecnologías de la información',
            'objetivo' => 'Enseñar las bases de todos los paradigmas de la programación y mostrar la ventana
de oportunidades que libera',
            'contenido' => '1. ¿Qué es la programación?
2. Paradigmas de programación
  2.1 ¿En qué consisten los paradigmas de programación?
   2.11 Historia
3. Lenguajes de programación
4. Ejercicios
5. Ejemplos en la vida diaria
6. Temas avanzados',
            'antecedentes' => 'Conocimientos básicos de informática y tecnologías de información: 
Qué es una computadora y cómo funciona',
            'fecha_disenio' => '2018-05-18',
            'clave_curso' => 'ADFVJ0911598'

        ]);
        DB::table('catalogo_cursos')->insert([
            'nombre_curso' =>'Administración',
            'duracion_curso' => '20',
            'coordinacion_id' => 2,
            'tipo' => 'E',
            'institucion' => 'DGAPA',
            'dirigido' => 'Administradores',
            'objetivo' => 'Que los que tomen el curso refuerzen sus conocimientos administrativos',
            'contenido' => 'Que es la administracion y sus derivados',
            'fecha_disenio' => '2018-05-18',
            'clave_curso' => 'FJHCZC'

        ]);
        DB::table('catalogo_cursos')->insert([
            'nombre_curso' =>'Ecuaciones Diferenciales',
            'duracion_curso' => '20',
            'coordinacion_id' => 3,
            'tipo' => 'S',
            'institucion' => 'DGAPA',
            'dirigido' => 'Ingenieros',
            'objetivo' => 'Aprender sobre ecuaciones diferenciales',
            'contenido' => 'Lo basico de ecuaciones diferenciales',
            'fecha_disenio' => '2018-05-18',
            'clave_curso' => 'ED1HCZ12'

        ]);
        DB::table('catalogo_cursos')->insert([
            'nombre_curso' =>'Cálculo Integral',
            'duracion_curso' => '20',
            'coordinacion_id' => 3,
            'tipo' => 'D',
            'institucion' => 'CDD',
            'dirigido' => 'Alumnos de ingenieria',
            'objetivo' => 'Aprender a integrar',
            'contenido' => 'Metodos de integracion',
            'fecha_disenio' => '2018-05-18',
            'clave_curso' => 'CI2HCZA'

        ]);
        DB::table('catalogo_cursos')->insert([
            'nombre_curso' =>'Álgebra Lineal',
            'duracion_curso' => '20',
            'coordinacion_id' => 3,
            'tipo' => 'C',
            'institucion' => 'CDD',
            'dirigido' => 'Alumno que ya acabaron Algebra',
            'objetivo' => 'Que la gente aprenda algebra lineal',
            'contenido' => 'Transformaciones lineales y espacios vectoriales',
            'fecha_disenio' => '2018-05-18',
            'clave_curso' => 'ALA3HCZ'

        ]);
        DB::table('catalogo_cursos')->insert([
            'nombre_curso' =>'Álgebra',
            'duracion_curso' => '20',
            'coordinacion_id' => 4,
            'tipo' => 'C',
            'institucion' => 'CDD',
            'dirigido' => 'Todo el publico',
            'objetivo' => 'Que los que tomen el curso aprendan lo basico de Algebra',
            'contenido' => 'Matrices y polinomios',
						'fecha_disenio' => '2018-05-18',
            'clave_curso' => 'A1A27HCZ'

        ]);
        DB::table('catalogo_cursos')->insert([
            'nombre_curso' =>'Análisis Numérico',
            'duracion_curso' => '20',
            'coordinacion_id' => 1,
            'tipo' => 'C',
            'institucion' => 'CDD',
            'dirigido' => 'Alumno que ya cursaron ecuaciones diferenciales',
            'objetivo' => 'Aprender sobre analisis numerico',
            'contenido' => 'Temas de Análisis Numérico',
            'fecha_disenio' => '2018-05-18',
            'clave_curso' => 'AN412HCZ'

        ]);
        DB::table('catalogo_cursos')->insert([
            'nombre_curso' =>'Programación Estructurada',
            'duracion_curso' => '10',
            'coordinacion_id' => 1,
            'tipo' => 'CT',
            'institucion' => 'CDD',
            'dirigido' => 'Alumnos de la carrera de ingenieria en computación',
            'objetivo' => 'Aprender temas avanzados de programacion ',
            'contenido' => 'Temas Avanzados de programacion',
            'fecha_disenio' => '2018-05-18',
            'clave_curso' => 'ADFVJ080578451'

        ]);
        DB::table('catalogo_cursos')->insert([
            'nombre_curso' =>'Administración Básica',
            'duracion_curso' => '20',
            'coordinacion_id' => 1,
            'tipo' => 'C',
            'institucion' => 'DGAPA',
            'dirigido' => 'Administradores expertos',
            'objetivo' => 'Aprender todo sobre administracion',
            'contenido' => 'Temas avanzados de aministracion',
            'fecha_disenio' => '2018-05-18',
            'clave_curso' => 'FJHCZA'
        ]);
        //TEMAS DE SEMINARIO PARA CURSO ECUACIONES DIFERENCIALES
        DB::table('temas_seminarios')->insert([
          'nombre' =>'Ecuaciones Básicas',
          'duracion' => 5,
          'catalogo_id' => 3
        ]);

        DB::table('temas_seminarios')->insert([
          'nombre' =>'Ecuaciones Avanzadas',
          'duracion' => 5,
          'catalogo_id' => 3
        ]);

        //CURSOS DE PRUEBA
        DB::table('cursos')->insert([
            'semestre_anio' => 2020,
            'semestre_pi'=>"2",
            'semestre_si' => "i",
            'fecha_inicio' => '2020-01-01',
            'fecha_fin' => '2020-05-30',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
            'dias_semana' => 'Lunes,Martes',
            'numero_sesiones' => 10,
            'costo' => 2000,
            'cupo_maximo' => 32,
            'cupo_minimo' => 1,
            'catalogo_id' => 1,
            'salon_id' => 1
        ]);

        DB::table('cursos')->insert([
            'semestre_anio' => 2020,
            'semestre_pi'=>"2",
            'semestre_si' => "i",
            'fecha_inicio' => '2020-12-01',
            'fecha_fin' => '2020-12-30',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
            'dias_semana' => 'Lunes,Martes',
            'numero_sesiones' => 10,
            'costo' => 2000,
            'cupo_maximo' => 5,
            'cupo_minimo' => 1,
            'catalogo_id' => 2,
            'salon_id' => 1
        ]);
        DB::table('cursos')->insert([
            'semestre_anio' => 2020,
            'semestre_pi'=>"2",
            'semestre_si' => "s",
            'fecha_inicio' => '2020-01-03',
            'fecha_fin' => '2020-05-30',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
            'dias_semana' => 'Lunes,Martes',
            'numero_sesiones' => 10,
            'costo' => 2000,
            'cupo_maximo' => 20,
            'cupo_minimo' => 5,
            'catalogo_id' => 3,
            'salon_id' => 1
        ]);

        DB::table('cursos')->insert([
            'semestre_anio' => 2020,
            'semestre_pi'=>"2",
            'semestre_si' => "i",
            'fecha_inicio' => '2020-12-01',
            'fecha_fin' => '2020-12-14',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
            'dias_semana' => 'Lunes,Martes',
            'numero_sesiones' => 10,
            'costo' => 2000,
            'cupo_maximo' => 20,
            'cupo_minimo' => 5,
            'catalogo_id' => 4,
            'salon_id' => 2
        ]);
        DB::table('cursos')->insert([
            'semestre_anio' => 2020,
            'semestre_pi'=>"2",
            'semestre_si' => "i",
            'fecha_inicio' => '2020-12-20',
            'fecha_fin' => '2020-12-30',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
            'dias_semana' => 'Lunes,Miércoles',
            'numero_sesiones' => 10,
            'costo' => 2000,
            'cupo_maximo' => 20,
            'cupo_minimo' => 5,
            'catalogo_id' => 6,
            'salon_id' => 3
        ]);
        DB::table('cursos')->insert([
            'semestre_anio' => 2015,
            'semestre_pi'=>"1",
            'semestre_si' => "s",
            'fecha_inicio' => '2015-12-20',
            'fecha_fin' => '2015-12-30',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
            'dias_semana' => 'Lunes,Miércoles',
            'numero_sesiones' => 10,
            'costo' => 2000,
            'cupo_maximo' => 20,
            'cupo_minimo' => 5,
            'catalogo_id' => 7,
            'salon_id' => 3
        ]);
        DB::table('cursos')->insert([
            'semestre_anio' => 2018,
            'semestre_pi'=>"2",
            'semestre_si' => "s",
            'fecha_inicio' => '2018-05-20',
            'fecha_fin' => '2018-05-30',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
            'dias_semana' => 'Lunes,Miércoles',
            'numero_sesiones' => 10,
            'costo' => 2000,
            'cupo_maximo' => 20,
            'cupo_minimo' => 5,
            'catalogo_id' => 3,
            'salon_id' => 2
        ]);
        DB::table('cursos')->insert([
            'semestre_anio' => 2018,
            'semestre_pi'=>"2",
            'semestre_si' => "i",
            'fecha_inicio' => '2018-05-20',
            'fecha_fin' => '2018-05-30',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
            'dias_semana' => 'Lunes,Miércoles',
            'numero_sesiones' => 10,
            'costo' => 2000,
            'cupo_maximo' => 20,
            'cupo_minimo' => 5,
            'catalogo_id' => 7,
            'salon_id' => 1
        ]);
        DB::table('cursos')->insert([
            'semestre_anio' => 2014,
            'semestre_pi'=>"2",
            'semestre_si' => "s",
            'fecha_inicio' => '2014-02-03',
            'fecha_fin' => '2014-05-30',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
            'dias_semana' => 'Lunes,Martes',
            'numero_sesiones' => 10,
            'costo' => 2000,
            'cupo_maximo' => 20,
            'cupo_minimo' => 5,
            'catalogo_id' => 5,
            'salon_id' => 1
        ]);
        
        //PROFESORES CON SU TEMA Y SU CURSO DE SEMINARIO
        DB::table('temas_seminario_profesor')->insert([
          'tema_id' => 1,
          'profesor_id' => 10,
          'curso_id' => 3
        ]);

        DB::table('temas_seminario_profesor')->insert([
          'tema_id' => 2,
          'profesor_id' => 10,
          'curso_id' => 3
        ]);

        //SECRETARIO DE APOYO A LA DOCENCIA
        DB::table('secretario_apoyo')->insert([
            'secretario' => "Claudia Loreto Miranda",
            'grado' => "Mtra."
        ]);

        //DIRECCIÓN DEL CENTRO DE DOCENCIA (DATO DE PRUEBA)
        DB::table('direccion')->insert([
            'director' => "Gabriel Aguilar Luna",
            'comentarios' => 'Ingeniero en computacion egresado de la UNAM, trabajo mucho tiempo en cargos administraticos en la FI',
            'grado' => "M.E.M."

        ]);

        //COORDINADOR GENERAL DEL CENTRO DE DOCENCIA
        DB::table('coordinador_general')->insert([
            'coordinador' => "Margarita Ramírez Galindo",
            'grado' => "M.E.M."

        ]);

        //ASIGNACIÓN DE INSTRUCTORES
        DB::table('profesor_curso')->insert([
          'curso_id' => "1",
          'profesor_id' => '1',
        ]);

        DB::table('profesor_curso')->insert([
          'curso_id' => "1",
          'profesor_id' => '2',
        ]);

        DB::table('profesor_curso')->insert([
          'curso_id' => "1",
          'profesor_id' => '3',
        ]);

        DB::table('profesor_curso')->insert([
          'curso_id' => "1",
          'profesor_id' => '4',
        ]);

        DB::table('profesor_curso')->insert([
          'curso_id' => "2",
          'profesor_id' => '5',
        ]);

        DB::table('profesor_curso')->insert([
          'curso_id' => "2",
          'profesor_id' => '6',
        ]);

        DB::table('profesor_curso')->insert([
          'curso_id' => "2",
          'profesor_id' => '7',
        ]);

        DB::table('profesor_curso')->insert([
          'curso_id' => "3",
          'profesor_id' => '10',
        ]);

        DB::table('profesor_curso')->insert([
          'curso_id' => "4",
          'profesor_id' => '9',
        ]);

        DB::table('profesor_curso')->insert([
          'curso_id' => "4",
          'profesor_id' => '10',
        ]);

        DB::table('profesor_curso')->insert([
          'curso_id' => "5",
          'profesor_id' => '11',
        ]);

        DB::table('profesor_curso')->insert([
          'curso_id' => "6",
          'profesor_id' => '12',
        ]);

        DB::table('profesor_curso')->insert([
          'curso_id' => "7",
          'profesor_id' => '13',
        ]);

        DB::table('profesor_curso')->insert([
          'curso_id' => "8",
          'profesor_id' => '14',
        ]);

        DB::table('profesor_curso')->insert([
          'curso_id' => "9",
          'profesor_id' => '15',
        ]);

        DB::table('profesor_curso')->insert([
          'curso_id' => "9",
          'profesor_id' => '16',
        ]);

        //PARTICIPANTES DE LOS CURSOS
        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>35,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>34,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>33,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>32,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>31,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>30,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>29,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>28,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>27,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>26,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>25,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>24,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>23,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>22,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>21,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>20,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>19,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>18,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>17,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>16,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>15,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>14,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>13,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>12,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>11,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>10,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>9,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>8,
          'asistencia'=>true,
          'acreditacion'=>false,
          'calificacion'=>5,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>7,
          'asistencia'=>true,
          'acreditacion'=>true,
          'calificacion'=>10,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>6,
          'asistencia'=>true,
          'acreditacion'=>true,
          'calificacion'=>9,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>1,
          'profesor_id'=>5,
          'asistencia'=>true,
          'acreditacion'=>true,
          'calificacion'=>10,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>2,
          'profesor_id'=>15,
          'asistencia'=>true,
          'acreditacion'=>true,
          'calificacion'=>9,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>2,
          'profesor_id'=>16,
          'asistencia'=>true,
          'acreditacion'=>true,
          'calificacion'=>8,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>2,
          'profesor_id'=>17,
          'asistencia'=>true,
          'acreditacion'=>true,
          'calificacion'=>9,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>2,
          'profesor_id'=>18,
          'asistencia'=>true,
          'acreditacion'=>true,
          'calificacion'=>9,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>2,
          'profesor_id'=>19,
          'asistencia'=>true,
          'acreditacion'=>true,
          'calificacion'=>9,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>5,
          'profesor_id'=>17,
          'asistencia'=>true,
          'acreditacion'=>true,
          'calificacion'=>9,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>5,
          'profesor_id'=>2,
          'asistencia'=>true,
          'acreditacion'=>true,
          'calificacion'=>10,
					'espera'=>0
        ]);

        DB::table('participante_curso')->insert([
          'curso_id'=>4,
          'profesor_id'=>21,
          'asistencia'=>true,
          'acreditacion'=>true,
          'calificacion'=>10,
					'espera'=>0
        ]);

        //ENCUESTAS PARA REPORTE DE COMENTARIOS Y SUGERENCIAS
        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'Todo bien, aunque en muchas ocasiones el salón olía a atún',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>1,
          'participante_curso_id'=>1
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'Agradable ambiente, todo perfecto. Pero los instructores un poco impuntuales',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>1,
          'participante_curso_id'=>2
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'Hay que mejorar mucho, la ponencia fue muy aburrida',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>1,
          'participante_curso_id'=>3
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'Se necesitan nuevas sillas',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>1,
          'participante_curso_id'=>4
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'Incomodo, más aire acondicionado',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>1,
          'participante_curso_id'=>5
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'El proyector no funcionaba',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>1,
          'participante_curso_id'=>6
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'Felicitaciones a los instructores, todo perfecto',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>1,
          'participante_curso_id'=>7
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'ninguna',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>1,
          'participante_curso_id'=>8
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'Se necesitan muchos ajustes en el contenido del curso',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>1,
          'participante_curso_id'=>9
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'Mejorar la limpieza del aula',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>1,
          'participante_curso_id'=>10
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'A pesar de los pocos días, todo fue muy biene ejecutado',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>1,
          'participante_curso_id'=>11
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'Mejorar la seguridad del aula',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>1,
          'participante_curso_id'=>12
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'Trabajar en el manejo de la voz al exponer los temas',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>4,
          'participante_curso_id'=>39
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'Ninguno de los temas fue lo que yo esperaba',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>3,
          'participante_curso_id'=>38
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'Preferiría seguir con mis cursos online',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>3,
          'participante_curso_id'=>37
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'Se necesitan mas instructores',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>2,
          'participante_curso_id'=>36
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'No volver atrás por los que se atrasan',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>2,
          'participante_curso_id'=>35
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'Mejorar forma de evaluación',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>2,
          'participante_curso_id'=>34
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'Estoy satisfecho con el desempeño del curso',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>2,
          'participante_curso_id'=>33
        ]);

        DB::table('_evaluacion_final_curso')->insert([
          'p1_1'=>'80',
          'p1_2'=>'80',
          'p1_3'=>'80',
          'p1_4'=>'80',
          'p1_5'=>'80',
          'p2_1'=>'80',
          'p2_2'=>'80',
          'p2_3'=>'100',
          'p2_4'=>'80',
          'p3_1'=>'100',
          'p3_2'=>'100',
          'p3_3'=>'100',
          'p3_4'=>'100',
          'p7'=>true,
          'p8'=>'["1","null"]',
          'mejor'=>'El conocimiento de nuevas herramientas',
          'sug'=>'Se necesita más conocimiento y mejor material didáctico',
          'p4_1'=>'100',
          'p4_2'=>'100',
          'p4_3'=>'100',
          'p4_4'=>'100',
          'p4_5'=>'100',
          'p4_6'=>'100',
          'p4_7'=>'100',
          'p4_8'=>'100',
          'p4_9'=>'80',
          'p4_10'=>'100',
          'p4_11'=>'80',
          'p5_1'=>'100',
          'p5_2'=>'100',
          'p5_3'=>'100',
          'p5_4'=>'100',
          'p5_5'=>'100',
          'p5_6'=>'100',
          'p5_7'=>'100',
          'p5_8'=>'100',
          'p5_9'=>'80',
          'p5_10'=>'100',
          'p5_11'=>'80',
          'otros'=>'programacion',
          'conocimiento'=>'["2"]',
          'tematica'=>'tematica',
          'horarios'=>'9:00-13:00',
          'horarioi'=>'13:00-15:00',
          'curso_id'=>2,
          'participante_curso_id'=>32
        ]);

    }
}