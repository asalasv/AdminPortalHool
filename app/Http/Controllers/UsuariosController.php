<?php

namespace App\Http\Controllers;

use Auth; 
use Illuminate\Http\Request;
use App\Clientes_Usuarios;
use App\Usuarios_ph;
use App\Cliente;

use Illuminate\Support\Facades\Session;

use Requests;

class UsuariosController extends Controller
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

    public function index(){

        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $user=Auth::user();

        $clientes = $this->getclientes();

        $id_cliente = $this->getIdcliente();
        $cliente = Cliente::findOrFail($id_cliente);
        $clientes_usuarios = \DB::table('clientes_usuarios')->where('id_cliente', '=', $id_cliente)->get();
        $usuariosid = array();
        
        foreach ($clientes_usuarios as $usuario) {
            array_push($usuariosid, $usuario->id_usuario_ph);
        }

        $usuarios = Usuarios_ph::whereIn('id_usuario_ph', $usuariosid)->paginate(15);

        return view('users/users',compact('usuarios','cliente','clientes','clientes_usuarios'));
    }

    public function verifyemail($email){

        $usuario = Usuarios_ph::where('email', '=', $email);

        if($usuario->first()){
            return 'true';
        }
        return 'false';
    }

    public function changestatus(){

        $id_cliente = $this->getIdcliente();
        $cliente = Cliente::findOrFail($id_cliente);
        if ($cliente->privado == 'V') {
            $cliente->privado = 'F';
        }else
            $cliente->privado = 'V';

            $cliente->save();

            return 'Estatus cambiado';

    }


    public function destroy($id, Request $request){
        
        //tambien validar que el id_cliente sea el this cliente

        $usuarios = explode(",", $id);

        foreach ($usuarios as $id) {

            $sql = 'DELETE FROM clientes_usuarios WHERE id_cliente = '.$this->getIdcliente().' AND id_usuario_ph = '.$id;
            $results = \DB::statement($sql);
        }

        if(count($usuarios) < 2){
            $cliente = Clientes_Usuarios::where('id_usuario_ph', '=', $id)->where('id_cliente', '=', $this->getIdcliente());

            $cliente = $cliente->first();

            $usuario = Usuarios_ph::where('id_usuario_ph', '=', $id);

            $message = $usuario->first()->nombre . " fue eliminado de sus registros";
       } else
            $message = " Los usuarios fueron eliminados de sus registros";

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

    public function changestatusph($id, Request $request){

        $cliente = Clientes_Usuarios::where('id_usuario_ph', '=', $id)->where('id_cliente', '=', $this->getIdcliente());

        $cliente = $cliente->first();

        if($cliente->status == 1){
            $sql = 'UPDATE clientes_usuarios SET status = 0 WHERE id_cliente = '.$this->getIdcliente().' AND id_usuario_ph = '.$cliente->id_usuario_ph;
            $results = \DB::statement($sql);
            return 'Usuario deshabilitado';
        }else{
            $sql = 'UPDATE clientes_usuarios SET status = 1 WHERE id_cliente = '.$this->getIdcliente().' AND id_usuario_ph = '.$cliente->id_usuario_ph;
            $results = \DB::statement($sql);
            return 'Usuario habilitado';
        }

    }

    public function habilitarph($id, Request $request){
        
        $usuarios = explode(",", $id);

        foreach ($usuarios as $usuario) {
            $sql = 'UPDATE clientes_usuarios SET status = 1 WHERE id_cliente = '.$this->getIdcliente().' AND id_usuario_ph = '.$usuario;
            $results = \DB::statement($sql);
        }

        return 'ok';
    }


    public function inhabilitarph($id, Request $request){
        
        $usuarios = explode(",", $id);

        foreach ($usuarios as $usuario) {
            $sql = 'UPDATE clientes_usuarios SET status = 0 WHERE id_cliente = '.$this->getIdcliente().' AND id_usuario_ph = '.$usuario;
            $results = \DB::statement($sql);
        }

        return 'ok';
    }

}
