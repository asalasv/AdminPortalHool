<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class EmailingController extends Controller
{
   	public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIdcliente(){

        $user=Auth::user();

        $sql1 = "SELECT id_cliente
        FROM clientes
        WHERE id_usuario_web =".$user->id_usuario_web;

        $rows = \DB::select($sql1);  

        if(count($rows)){
            return $rows[0]->id_cliente;
        }else{
            return null;
        }

    }

    public function index(){

    	return view('emailing/emailing');
    }
}
