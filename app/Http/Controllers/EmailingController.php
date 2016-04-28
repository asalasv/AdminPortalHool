<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use Auth; 
use Illuminate\Support\Facades\Session;
use App\Http\Requests;

class EmailingController extends Controller
{
   	public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIdcliente(){

        return Session::get('client.id_cliente');

    }

    public function index(){
        $user=Auth::user();

        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = Cliente::where('id_usuario_web', $user->id_usuario_web)->get();

    	return view('emailing/emailing',compact('clientes'));
    }
}
