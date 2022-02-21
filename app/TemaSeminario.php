<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemaSeminario extends Model
{
    protected $table = 'temas_seminarios';

    protected $fillable = [
        'id', 'nombre', 'duracion','catalogo_id'
    ];
}
