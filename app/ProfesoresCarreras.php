<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfesoresCarreras extends Model
{
    protected $table = 'profesores_carreras';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'id_profesor','id_carrera'];
}
