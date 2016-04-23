<?php

namespace App\Http\Controllers;

use Auth; 
use Illuminate\Http\Request;
use App\Clientes_Usuarios;
use App\Usuarios_ph;

use Requests;

class UsuariosController extends Controller
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

        $id_cliente = $this->getIdcliente();
        $clientes_usuarios = \DB::table('clientes_usuarios')->where('id_cliente', '=', $id_cliente)->get();
        $usuariosid = array();
        
        foreach ($clientes_usuarios as $usuario) {
            array_push($usuariosid, $usuario->id_usuario_ph);
        }

        $usuarios = Usuarios_ph::whereIn('id_usuario_ph', $usuariosid)->paginate(15);

        return view('users/users',compact('usuarios'));
    }

    public function verifyemail($email){

        $usuario = Usuarios_ph::where('email', '=', $email);

        if($usuario->first()){
            return 'true';
        }
        return 'false';
    }


    public function destroy($id, Request $request){
            
        $cliente = \DB::table('clientes_usuarios')->where('id_usuario_ph', '=', $id);

        $usuario = Usuarios_ph::where('id_usuario_ph', '=', $id);

        $cliente->delete();

        $message = $usuario->first()->nombre . " fue eliminado de nuestros registros";

        return $message;

    }

    public function add($email, Request $request){

        
        $usuario = Usuarios_ph::where('email', '=', $email);

        if($usuario->first()){

            $newuser = new Clientes_Usuarios();

            $newuser->id_cliente = $this->getIdcliente();

            $newuser->id_usuario_ph = $usuario->first()->id_usuario_ph;

            $newuser->save();

            return 'refresh';
        }
        
        return $usuario->first();
    }

}
