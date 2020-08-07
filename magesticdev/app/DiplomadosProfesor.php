<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiplomadosProfesor extends Model
{
    protected $table = 'diplomado_profesor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'diplomado_id','profesor_id'];
}
