<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CategoriaNivel extends Model
{
    protected $table = "categoria_nivel";
    protected $fillable = [
        'categoria', 'abreviatura'
    ];

}
