<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfesoresDivisiones extends Model
{
  protected $table = 'profesores_divisiones';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id_profesor','id_division'];
}
