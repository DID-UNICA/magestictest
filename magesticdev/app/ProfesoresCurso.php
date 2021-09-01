<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfesoresCurso extends Model
{
    protected $table = 'profesor_curso';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'curso_id','profesor_id','tema_seminario_id', 'folio_inst','folio_peque','fecha_envio'];

    public function getProfesor(){
      return Profesor::findOrFail($this->profesor_id);
    }
}
