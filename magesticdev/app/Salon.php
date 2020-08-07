<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    protected $table = 'salons';


    protected $fillable = [
     'sede','capacidad','ubicacion'
    ];
    

}

