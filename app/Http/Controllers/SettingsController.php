<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

class SettingsController extends Controller
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

    public function changepass(){
    	return view('settings/editpassword');
    }

    public function updatepass(Request $request){

    	 $user=Auth::user();

    	 $pass = $request->password;

    	 $user->password = bcrypt($pass);

    	 $user->save();

    	 return redirect('home');

    }
}
