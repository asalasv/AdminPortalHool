<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    protected $table = 'sesiones';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'id_equipo', 'ip', 'usuario', 'sesion', 'mac'
    ];

    public $timestamps = false;
}
