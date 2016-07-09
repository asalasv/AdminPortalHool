<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth; 
use App\Cliente;
use App\Sesion;
use App\Quotation;
use DB;
use Illuminate\Support\Facades\Session;


class SessionsController extends Controller
{


    public function getIdcliente(){

        return Session::get('client.id_cliente');

    }

    public function index(){
        $user=Auth::user();

        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        // dd("shell_exec('./sesiones.sh '".$this->getIdcliente().");");

        //shell_exec('./sesiones.sh '.$this->getIdcliente());

        $clientes = Cliente::where('id_usuario_web', $user->id_usuario_web)->get();

        $sesiones = Sesion::where('id_equipo', $this->getIdcliente())->get();

    	return view('sessions',compact('clientes', 'sesiones'));
    }

    public function desconectar($sesion, Request $request){

    	shell_exec('./desconexion.sh '.$this->getIdcliente().' '.$sesion);

    	return 'ok';
    }

    
}
