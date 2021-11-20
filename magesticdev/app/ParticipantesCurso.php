<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Db;

class ParticipantesCurso extends Model
{
    protected $table = 'participante_curso';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'curso_id','profesor_id','confirmacion','asistencia','pago_curso',
        'monto_pago','cancelación',
        'espera', 'estuvo_en_lista','contesto_hoja_evaluacion','acreditacion',
        'causa_no_acreditacion','calificacion','inscrito','comentario','adicional',
        'folio_inst','folio_peque'
    ];
    public function getProfesor(){
        $profesor = Profesor::find($this->profesor_id);
        return $profesor;
    }
    public function getCatalogoCurso(){
        $curso = Curso::find($this->curso_id);
        $catalogo = CatalogoCurso::find($curso->catalogo_id);
        return $catalogo;
    }
    public function getCurso(){
        $curso = Curso::find($this->curso_id);
        return $curso;
    }
}
