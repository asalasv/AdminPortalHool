<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portal extends Model
{
    protected $table = 'portales_cliente';

    protected $fillable = [
       'id_portal_cliente','id_cliente','descripcion','predeterminado','lienzo','imagen_blicidad','imagen_logo','imagen_fondo','color_fondo','fecha_inicio','fecha_fin','hora_inicio','hora_fin'
    ];

    public $timestamps = false;

    protected $primaryKey = 'id_portal_cliente';

}