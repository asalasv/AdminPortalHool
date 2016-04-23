<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuarios_ph extends Model
{
    protected $table = 'usuarios_ph';

    protected $fillable = [
       'id_usuario_ph','email','nombre','apellido','birthday','sex','country','id_confirmacion','status',
    ];

    public $timestamps = false;

    protected $primaryKey = 'id_usuario_ph';
}
