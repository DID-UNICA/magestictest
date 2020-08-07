<?php
/**
 * Created by PhpStorm.
 * User: gmeono
 * Date: 10/12/17
 * Time: 02:05 PM
 */

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Division extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = "divisions";
    protected $fillable = [
        'nombre',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
    public function getNombre()
    {
        return $this->nombre;
    }
}
