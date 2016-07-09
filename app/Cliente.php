<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
       'id_cliente','nombre','tax_number','alias','direccion','email','telefono','representante','id_usuario_web','password',
    ];

    public $timestamps = false;

    protected $primaryKey = 'id_cliente';

}