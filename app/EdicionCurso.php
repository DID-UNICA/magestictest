<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EdicionCurso extends Model
{
    protected $table = 'edicion_cursos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'semestre_imparticion','periodo_semestre','fecha_inicio','fecha_fin','hora_inicio','hora_fin',
        'dias_semana','numero_sersiones','costo','orden','fecha','cupo_maximo','cupo_minimo','status_curso',
        'profesor_id','curso_id','salon_id'
    ];
    public function getCurso(){
        $curso = Curso::findOrFail($this->curso_id)->nombre;
        return $curso;
    }
    public function getProfesor(){
        $profesor = Profesor::findOrFail($this->profesor_id)->nombres;
        return $profesor;
    }
    public function getProfesorApellidoP(){
        $profesor = Profesor::findOrFail($this->profesor_id)->apellido_paterno;
        return $profesor;
    }
    public function getProfesorApellidoM(){
        $profesor = Profesor::findOrFail($this->profesor_id)->apellido_materno;
        return $profesor;
    }
    public function getSalon(){
        $ubicacion = Salon::findOrFail($this->salon_id)->ubicacion;
        return $ubicacion;
    }
    public function getSede(){
        $sede = Salon::findOrFail($this->salon_id)->sede;
        return $sede;
    }
    
}
