<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemaSeminario extends Model
{
    protected $table = 'temas_seminarios';

    protected $fillable = [
        'id', 'nombre', 'duracion','catalogo_id'
    ];

    public function getProfesorCurso($curso_id){
        $tsp = TemaSeminarioProfesor::where('tema_id',$this->id)
        ->where('curso_id',$curso_id)->get();
        if($tsp->isNotEmpty()){ //Esta esta mal pero quiero un pan
            $profesor = Profesor::findOrFail($tsp[0]->profesor_id);
            return $profesor;
        } else{return FALSE;}
    }
}
