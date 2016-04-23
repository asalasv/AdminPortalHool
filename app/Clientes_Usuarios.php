<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes_Usuarios extends Model
{
    protected $table = 'clientes_usuarios';

    protected $fillable = [
       'id_cliente','id_usuario_ph',
    ];

    public $timestamps = false;

}
