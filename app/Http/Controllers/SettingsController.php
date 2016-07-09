<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Cliente;
use Illuminate\Support\Facades\Session;
use Auth;

class SettingsController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIdcliente(){

        return Session::get('client.id_cliente');

    }

    public function getclientes(){
        $user=Auth::user();

        $clientes = Cliente::where('id_usuario_web', $user->id_usuario_web)->get();

        return $clientes;
    }

    public function changepass(){
        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = $this->getclientes();

    	return view('settings/editpassword',compact('clientes'));
    }

    public function updatepass(Request $request){

    	 $user=Auth::user();

    	 $pass = $request->password;

    	 $user->password = bcrypt($pass);

    	 $user->save();

    	 return redirect('home');
    }

    public function portalpass(){
        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = $this->getclientes();

        return view('settings/portalpassword',compact('clientes'));
    }

    public function updateportalpass(Request $request){

        $cliente = Cliente::findOrFail($this->getIdcliente());

        $cliente->password = $request->password;

        $cliente->save();

        return redirect('home');
    }

}
