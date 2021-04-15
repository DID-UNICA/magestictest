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

        //TABLA DE DIVISIONES DE LA FACULTAD DE INGENIERÍA
        DB::table('divisions')->insert([
            'nombre' => 'División de Ciencias Básicas'
        ]);
        
        DB::table('divisions')->insert([
          'nombre' => 'División de Ingeniería Civil y Geomática'
        ]);

        DB::table('divisions')->insert([
            'nombre' => 'División de Ingeniería Eléctrica'
        ]);

        DB::table('divisions')->insert([
          'nombre' => 'División de Ingeniería en Ciencias de la Tierra'
        ]);

        DB::table('divisions')->insert([
          'nombre' => 'División de Ingeniería Mecánica e Industrial'
        ]);

        DB::table('divisions')->insert([
            'nombre' => 'División de Ciencias Sociales y Humanidades'
        ]);

        DB::table('divisions')->insert([
          'nombre' => 'División de Educación Continua y a Distancia'
        ]);

        DB::table('divisions')->insert([
          'nombre' => 'Becarios de UNICA'
        ]);

        DB::table('divisions')->insert([
          'nombre' => 'Servicio social'
        ]);

        DB::table('divisions')->insert([
          'nombre' => 'Externos'
        ]);

        DB::table('divisions')->insert([
            'nombre' => 'Secretarias'
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
            'semblanza_corta'=> 'Doctorado en Inteligencia Artificial,
                             su carrera es respaldada por 25 años de 
                             ejercer la doctrina de profesor. Ganó el premio
                             S@T por el código más pequeño del mundo',
            'genero' => 'masculino',
            'comentarios' => 'hombre alto, de tez blanca, cabello negro y ojos marrones. ',
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
            'semblanza_corta' => 'Profesora de la facultad de ingeniería,
                             fundó la asociación de mujeres programadoras
                             con el fin de impulsar los derechos y la presencia
                             de la mujer en el ámbito profesional de las Tecnologías
                             de la Información. Es egresada de la Facultad de Ciencias.
                             Doctora en análisis de datos.',
            'genero' => 'femenino',
            'comentarios' => 'Mujer delgada, de tez morena, cabello negro y ojos cafes.',
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
            'semblanza_corta' => 'Ingeniero geofisico, con especilidad en volcanes 
                                  y terremotos y maestria en rocas.',
            'genero' => 'masculino',
            'comentarios' => 'Señor alto, edad avanzada, pelo y barba canosas y usa lentes',
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
            'semblanza_corta' => 'Licenciada en administracion egresada de la 
                                  FCyA de la UNAM con honores.',
            'genero' => 'femenino',
            'comentarios' => 'Mujer bajita, tez obscura, cabello negro.',
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
            'semblanza_corta' => 'Ingeniero mecanico con especialidad en diseño mecanico egresado de la unam y con maestria en Alemania.',
            'genero' => 'masculino',
            'comentarios' => 'Hombre alto, calvo y con barba muy grande',
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
            'comentarios' => 'Mujer de edad avanzada, cabello negro y orejas grandes',
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
            'comentarios' => 'Hombre de mucho peso, estatura promedio y larga cabellera rubia',
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
            'comentarios' => 'Mujer joven, alta, cabello negro y tez blanca',
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
            'comentarios' => 'Hombre de mediana edad, cabello negro y barba de candado',
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
            'semblanza_corta' => 'Licenciada en contaduria, con maestria en impuestos empresariales y doctorado en contaduria para Macroempresas.',
            'genero' => 'femenino',
            'comentarios' => 'Mujer de baja estatura, delgada y con ojos cafes.',
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
            'comentarios' => 'Hombre con rascos asiaticos, tez blanca y ojos rasgados.',
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
            'comentarios' => 'Mujer afroamericana de alta estatura y cabello cafe.',
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
            'comentarios' => 'Hombre alto, afroamericano con cabello negro.',
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
            'comentarios' => 'Mujer de corta estatura, ojos azules y cabello color cafe',
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
            'comentarios' => 'Hombre de baja estatura, sin cabello y utiliza lentes',
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
            'semblanza_corta' => 'Ingeniera insdustrial enfocada al area de logistica con maestry en cadena de suministros en Canada.',
            'genero' => 'femenino',
            'comentarios' => 'Mujer de edad avanzada con pelo rubio y orejas grandes.',
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
            'comentarios' => 'Hombre con enanismo, de tez blanca y pelo negro.',
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
            'comentarios' => 'Mujer alta, delgada, con el pelo pintado de azul.',
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
            'comentarios' => 'Hombre alto, con mucha musculatura, pelo y barba de color castaño claro.',
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
            'semblanza_corta' => 'Licencidad en contaduria, ella calcula los imppuestos de la unam y tiene maestria en impuestos universitarios.',
            'genero' => 'femenino',
            'comentarios' => 'Mujer de estatura promedio, de tez morena con nariz grande y pelo negro',
            'facebook' => 'Viridiana Valencia',
            'unam' => true,
            'facultad_id' =>5
        ]);

        //COORDINACIONES DEL CENTRO DE DOCENCIA, COORDINADORES DE PRUEBA
        DB::table('coordinacions')->insert([
          'abreviatura'=>'CO',
          'nombre_coordinacion'=>'Área de Cómputo',
          'coordinador'=>'Gerardo Lopez Gomez',
          'grado'=>'M.C.C',
          'usuario'=>'G3rardo1nEZ',
          'password'=>'$10$Sli0p2.SdjP7JTbyze.RIucCUJA5MOG6AEB40sJG3Ok3Kb33ltibl'
        ]);
    
        DB::table('coordinacions')->insert([
          'abreviatura'=>'DI',
          'nombre_coordinacion'=>'Área Disciplinar e Investigación Educativa',
          'coordinador'=>'Roman Dominguez Perez',
          'grado'=>'M.E.M.',
          'usuario'=>'R0m4n1nEZ',
          'password'=>'$10$Sli0p2.SdjP7JTbyze.RIucCUJA5MOG6AEB40sJG3Ok3Kb33ltibn'
        ]);
        
        DB::table('coordinacions')->insert([
          'nombre_coordinacion' => 'Área Didáctico Pedagógica',
          'abreviatura' => 'DP',
          'coordinador' => 'Daniel Morales',
          'grado' => 'M.E.M.',
          'usuario' => 'daniel',
          'password' => Hash::make('1234'),
          'comentarios' => '-'
        ]);
    
        DB::table('coordinacions')->insert([
          'nombre_coordinacion' => 'Área de Desarrollo Humano',
          'abreviatura' => 'DH',
          'coordinador' => 'Jacob Hernandez',
          'grado' => 'M.E.M.',
          'usuario' => 'jacob',
          'password' => Hash::make('1234'),
          'comentarios' => '-'
      ]);

      //CATÁLOGO DE CURSOS DE PRUEBA
        DB::table('catalogo_cursos')->insert([
            'nombre_curso' =>'Programacion Estructurada',
            'duracion_curso' => '10',
            'coordinacion_id' => 1,
            'tipo' => 'CT',
            'institucion' => 'CDD',
            'presentacion' => 'Presentacion',
            'dirigido' => 'Personas interesadas en el área 
                            de la programación, desarrollo de software 
                            y tecnologías de la información',
            'objetivo' => 'Enseñar las bases de todos los paradigmas de la programación
                            y mostrar la ventana de oportunidades que libera',
            'contenido' => '-¿Qué es la programación?
                            -Paradigmas de programación
                            -Lenguajes de programación
                            -Ejercicios
                            -Ejemplos en la vida diaria
                            -Temas avanzados',
            'sintesis' => 'Sintesis',
            'metodologia' => 'Metodologia',
            'previo' => 'Conocimientos básicos de informática y tecnologías de información: Qué es una computadora y cómo funciona',
            'bibliografia' => 'www.paginasobreprogramacion.com
            A.J. Tyson, Programacion para dummys. Pearson, 2008.',
            'fecha_disenio' => '2018-05-18',
            'clave_curso' => 'ADFVJ0911598'

        ]);
        DB::table('catalogo_cursos')->insert([
            'nombre_curso' =>'Administración',
            'duracion_curso' => '20',
            'coordinacion_id' => 1,
            'tipo' => 'E',
            'institucion' => 'DGAPA',
            'presentacion' => 'Presentacion',
            'dirigido' => 'Administradores',
            'objetivo' => 'Que los que tomen el curso refuerzen sus conocimientos administrativos',
            'contenido' => 'Que es la administracion y sus derivados',
            'sintesis' => 'Se aprendera sobre la administracion',
            'metodologia' => 'Presencial',
            'bibliografia' => 'El libro sobre administracion',
            'fecha_disenio' => '2018-05-18',
            'clave_curso' => 'FJHCZC'

        ]);
        DB::table('catalogo_cursos')->insert([
            'nombre_curso' =>'Ecuaciones Diferenciales',
            'duracion_curso' => '20',
            'coordinacion_id' => 1,
            'tipo' => 'S',
            'institucion' => 'DGAPA',
            'presentacion' => 'Presentacion',
            'dirigido' => 'Ingenieros',
            'objetivo' => 'Aprender sobre ecuaciones diferenciales',
            'contenido' => 'Lo basico de ecuaciones diferenciales',
            'sintesis' => 'Aqui se aprenderan las bases para resolver ecuaciones diferenciales',
            'metodologia' => 'presencial',
            'bibliografia' => 'Zill',
            'fecha_disenio' => '2018-05-18',
            'clave_curso' => 'ED1HCZ12'

        ]);
        DB::table('catalogo_cursos')->insert([
            'nombre_curso' =>'Cálculo Integral',
            'duracion_curso' => '20',
            'coordinacion_id' => 1,
            'tipo' => 'D',
            'institucion' => 'CDD',
            'presentacion' => 'Presentacion',
            'dirigido' => 'Alumnos de ingenieria',
            'objetivo' => 'Aprender a integrar',
            'contenido' => 'Metodos de integracion',
            'sintesis' => 'Se aprendera a integrar mub bien en este curso',
            'metodologia' => 'Presencial',
            'bibliografia' => 'Libro de Integrales',
            'fecha_disenio' => '2018-05-18',
            'clave_curso' => 'CI2HCZA'

        ]);
        DB::table('catalogo_cursos')->insert([
            'nombre_curso' =>'Álgebra Lineal',
            'duracion_curso' => '20',
            'coordinacion_id' => 1,
            'tipo' => 'C',
            'institucion' => 'CDD',
            'presentacion' => 'Presentacion',
            'dirigido' => 'Alumno que ya acabaron Algebra',
            'objetivo' => 'Que la gente aprenda algebra lineal',
            'contenido' => 'Transformaciones lineales y espacios vectoriales',
            'sintesis' => 'Aqui se aprendera algebra vectorial',
            'metodologia' => 'presencial',
            'bibliografia' => 'Libro de Algebra Lineal',
            'fecha_disenio' => '2018-05-18',
            'clave_curso' => 'ALA3HCZ'

        ]);
        DB::table('catalogo_cursos')->insert([
            'nombre_curso' =>'Álgebra',
            'duracion_curso' => '20',
            'coordinacion_id' => 1,
            'tipo' => 'C',
            'institucion' => 'CDD',
            'presentacion' => 'Presentacion',
            'dirigido' => 'Todo el publico',
            'objetivo' => 'Que los que tomen el curso aprendan lo basico de Algebra',
            'contenido' => 'Matrices y polinomios',
            'sintesis' => 'Aquí se aprenderá sobre Álgebra',
            'metodologia' => 'Presencia',
            'bibliografia' => 'Libro de Álgebra',
            'fecha_disenio' => '2018-05-18',
            'clave_curso' => 'A1A27HCZ'

        ]);
        DB::table('catalogo_cursos')->insert([
            'nombre_curso' =>'Análisis Numérico',
            'duracion_curso' => '20',
            'coordinacion_id' => 1,
            'tipo' => 'C',
            'institucion' => 'CDD',
            'presentacion' => 'Presentacion',
            'dirigido' => 'Alumno que ya cursaron ecuaciones diferenciales',
            'objetivo' => 'Aprender sobre analisis numerico',
            'contenido' => 'Temas de Análisis Numérico',
            'sintesis' => 'Aqui se aprenderan los temas básicos de Ánalisis numérico',
            'metodologia' => 'Online',
            'bibliografia' => 'Libro de Analisis Numerico',
            'fecha_disenio' => '2018-05-18',
            'clave_curso' => 'AN412HCZ'

        ]);
        DB::table('catalogo_cursos')->insert([
            'nombre_curso' =>'Programación Estructurada',
            'duracion_curso' => '10',
            'coordinacion_id' => 1,
            'tipo' => 'CT',
            'institucion' => 'CDD',
            'presentacion' => 'Presentacion',
            'dirigido' => 'Alumnos de la carrera de ingenieria en computación',
            'objetivo' => 'Aprender temas avanzados de programacion ',
            'contenido' => 'Temas Avanzados de programacion',
            'sintesis' => 'En este curso los alumnos seran capaces al finalizar de programar cualquier cosa',
            'metodologia' => 'Online',
            'bibliografia' => 'Libro de super programación',
            'fecha_disenio' => '2018-05-18',
            'clave_curso' => 'ADFVJ080578451'

        ]);
        DB::table('catalogo_cursos')->insert([
            'nombre_curso' =>'Administración Básica',
            'duracion_curso' => '20',
            'coordinacion_id' => 1,
            'tipo' => 'C',
            'institucion' => 'DGAPA',
            'presentacion' => 'Presentacion',
            'dirigido' => 'Administradores expertos',
            'objetivo' => 'Aprender todo sobre administracion',
            'contenido' => 'Temas avanzados de aministracion',
            'sintesis' => 'En este curso se aprenderan los temas más avanzados de administracion',
            'metodologia' => 'Presencial', 
            'bibliografia' => 'Libro super avanzado de Administracion',
            'fecha_disenio' => '2018-05-18',
            'clave_curso' => 'FJHCZA'
        ]);

        //CURSOS DE PRUEBA
        DB::table('cursos')->insert([
            'semestre_anio' => 2020,
            'semestre_pi'=>"2",
            'semestre_si' => "i",
            'fecha_inicio' => '2019-12-04',
            'fecha_fin' => '2020-05-30',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
            'dias_semana' => 'Lunes,Martes',
            'numero_sesiones' => 10,
            'texto_diploma' => 'Texto diploma',
            'costo' => 2000,
            'cupo_maximo' => 5,
            'cupo_minimo' => 5,
            'catalogo_id' => 1,
            'salon_id' => 1
        ]);

        DB::table('cursos')->insert([
            'semestre_anio' => 2016,
            'semestre_pi'=>"2",
            'semestre_si' => "i",
            'fecha_inicio' => '2019-12-04',
            'fecha_fin' => '2019-12-30',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
            'dias_semana' => 'Lunes,Martes',
            'numero_sesiones' => 10,
            'texto_diploma' => 'Texto diploma',
            'costo' => 2000,
            'cupo_maximo' => 20,
            'cupo_minimo' => 5,
            'catalogo_id' => 5,
            'salon_id' => 1
        ]);
        DB::table('cursos')->insert([
            'semestre_anio' => 2018,
            'semestre_pi'=>"2",
            'semestre_si' => "s",
            'fecha_inicio' => '2019-12-03',
            'fecha_fin' => '2020-05-30',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
            'dias_semana' => 'Lunes,Martes',
            'numero_sesiones' => 10,
            'texto_diploma' => 'Texto diploma',
            'costo' => 2000,
            'cupo_maximo' => 20,
            'cupo_minimo' => 5,
            'catalogo_id' => 2,
            'salon_id' => 1
        ]);

        DB::table('cursos')->insert([
            'semestre_anio' => 2016,
            'semestre_pi'=>"2",
            'semestre_si' => "s",
            'fecha_inicio' => '2019-12-04',
            'fecha_fin' => '2018-12-07',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
            'dias_semana' => 'Lunes,Martes',
            'numero_sesiones' => 10,
            'texto_diploma' => 'Texto diploma',
            'costo' => 2000,
            'cupo_maximo' => 20,
            'cupo_minimo' => 5,
            'catalogo_id' => 3,
            'salon_id' => 2
        ]);
        DB::table('cursos')->insert([
            'semestre_anio' => 2017,
            'semestre_pi'=>"2",
            'semestre_si' => "s",
            'fecha_inicio' => '2019-12-20',
            'fecha_fin' => '2018-12-30',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
            'dias_semana' => 'Lunes,Miércoles',
            'numero_sesiones' => 10,
            'texto_diploma' => 'Texto diploma',
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
            'fecha_inicio' => '2019-12-20',
            'fecha_fin' => '2019-12-30',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
            'dias_semana' => 'Lunes,Miércoles',
            'numero_sesiones' => 10,
            'texto_diploma' => 'Texto diploma',
            'costo' => 2000,
            'cupo_maximo' => 20,
            'cupo_minimo' => 5,
            'catalogo_id' => 7,
            'salon_id' => 3
        ]);
        DB::table('cursos')->insert([
            'semestre_anio' => 2019,
            'semestre_pi'=>"2",
            'semestre_si' => "s",
            'fecha_inicio' => '2018-05-20',
            'fecha_fin' => '2018-05-30',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
            'dias_semana' => 'Lunes,Miércoles',
            'numero_sesiones' => 10,
            'texto_diploma' => 'Texto diploma',
            'costo' => 2000,
            'cupo_maximo' => 20,
            'cupo_minimo' => 5,
            'catalogo_id' => 3,
            'salon_id' => 2
        ]);
        DB::table('cursos')->insert([
            'semestre_anio' => 2019,
            'semestre_pi'=>"2",
            'semestre_si' => "i",
            'fecha_inicio' => '2018-05-20',
            'fecha_fin' => '2018-05-30',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
            'dias_semana' => 'Lunes,Miércoles',
            'numero_sesiones' => 10,
            'texto_diploma' => 'Texto diploma',
            'costo' => 2000,
            'cupo_maximo' => 20,
            'cupo_minimo' => 5,
            'catalogo_id' => 7,
            'salon_id' => 1
        ]);
        DB::table('cursos')->insert([
            'semestre_anio' => 2018,
            'semestre_pi'=>"2",
            'semestre_si' => "s",
            'fecha_inicio' => '2019-12-03',
            'fecha_fin' => '2020-05-30',
            'hora_inicio' => '14:00',
            'hora_fin' => '16:00',
            'dias_semana' => 'Lunes,Martes',
            'numero_sesiones' => 10,
            'texto_diploma' => 'Texto diploma',
            'costo' => 2000,
            'cupo_maximo' => 20,
            'cupo_minimo' => 5,
            'catalogo_id' => 4,
            'salon_id' => 1
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
    }
}