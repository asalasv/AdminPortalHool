<?php

namespace App\Http\Controllers;

use Request;
use Auth; 
use App\Http\Controllers\Controller;
use App\User;
use App\Cliente;
use DB;
use App\Quotation;
use DateTime;
use Illuminate\Support\Facades\Session;

class GraphicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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

    public function lastweekreg()
    {
        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = $this->getclientes();

        return view('graphics/lastweekreg',compact('clientes'));
    }

    //Registros Nuevos Ultima Semana
    public function newlastweekreg()
    {
        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = $this->getclientes();

        return view('graphics/newlastweekreg',compact('clientes'));
    }

    //Registros Nuevos Ultima Semana
    public function getnewlastweekreg()
    {
        if(Request::ajax()){

            $req = Request::all();

            $req = json_encode($req);

            $req = json_decode($req);

            $user=Auth::user();
            
            $sql1 = "SELECT id_cliente
                    FROM clientes
                    WHERE id_usuario_web =".$user->id_usuario_web;

            $rows = DB::select($sql1);

            if(count($rows)){
                $id_cliente = $rows[0]->id_cliente;

                if($req->desde and $req->hasta){

                    $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                    $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                    $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                            FROM `primer_registro_email`
                            WHERE `id_cliente` = ".$id_cliente.
                            " AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y')
                            GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                }else
                    if($req->desde){

                        $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                        $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                FROM `primer_registro_email`
                                WHERE `id_cliente` = ".$id_cliente.
                                " AND date_format(`fecha_registro`,'%m-%d-%Y')  > date_format( '".$req->desde."' ,'%m-%d-%Y') 
                                GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                    }else
                        if($req->hasta){

                            $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                            $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `primer_registro_email`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND date_format(`fecha_registro`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                        }else{
                            $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `primer_registro_email`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format(now()-interval 7 day,'%m-%d-%Y') and date_format(now(),'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                        }

                
            
                $results = DB::select($sql);

                return $results;


            }else
                return "El id del usuario '".$user->username."' no se encuentra en tabla clientes";
        }
    }

    //Conexiones al Portal Ultima Semana.
    public function connectlastweek()
    {
        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = $this->getclientes();

        return view('graphics/connectlastweek',compact('clientes'));
    }

    public function getconnectlastweek()
    {
        if(Request::ajax()){

            $req = Request::all();

            $req = json_encode($req);

            $req = json_decode($req);

            $user=Auth::user();
            
            $sql1 = "SELECT id_cliente
                    FROM clientes
                    WHERE id_usuario_web =".$user->id_usuario_web;

            $rows = DB::select($sql1);

            if(count($rows)){
                $id_cliente = $rows[0]->id_cliente;

                if($req->desde and $req->hasta){

                    $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                    $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                    $sql = "SELECT date_format(`fecha_actividad`,'%m-%d-%Y'), count(date_format(`fecha_actividad`,'%m-%d-%Y'))
                            FROM `actividad_portales`
                            WHERE `id_cliente` = ".$id_cliente.
                            " AND date_format(`fecha_actividad`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y')
                            GROUP BY date_format(`fecha_actividad`,'%m-%d-%Y')";
                }else
                    if($req->desde){

                        $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                        $sql = "SELECT date_format(`fecha_actividad`,'%m-%d-%Y'), count(date_format(`fecha_actividad`,'%m-%d-%Y'))
                                FROM `actividad_portales`
                                WHERE `id_cliente` = ".$id_cliente.
                                " AND date_format(`fecha_actividad`,'%m-%d-%Y')  > date_format( '".$req->desde."' ,'%m-%d-%Y') 
                                GROUP BY date_format(`fecha_actividad`,'%m-%d-%Y')";
                    }else
                        if($req->hasta){

                            $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                            $sql = "SELECT date_format(`fecha_actividad`,'%m-%d-%Y'), count(date_format(`fecha_actividad`,'%m-%d-%Y'))
                                    FROM `actividad_portales`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND date_format(`fecha_actividad`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_actividad`,'%m-%d-%Y')";
                        }else{
                            $sql = "SELECT date_format(`fecha_actividad`,'%m-%d-%Y'), count(date_format(`fecha_actividad`,'%m-%d-%Y'))
                                    FROM `actividad_portales`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND date_format(`fecha_actividad`,'%m-%d-%Y') between date_format(now()-interval 7 day,'%m-%d-%Y') and date_format(now(),'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_actividad`,'%m-%d-%Y')";
                        }
            
                $results = DB::select($sql);

                return $results;


            }else
                return "El id del usuario '".$user->username."' no se encuentra en tabla clientes";
        }
    }

    public function getlastweekreg(Request $request)
    {
        if($request::ajax()){

            $req = Request::all();

            $req = json_encode($req);

            $req = json_decode($req);

            $user=Auth::user();
            
            $sql1 = "SELECT id_cliente
                    FROM clientes
                    WHERE id_usuario_web =".$user->id_usuario_web;

            $rows = DB::select($sql1);

            if(count($rows)){
                $id_cliente = $rows[0]->id_cliente;

                if($req->desde and $req->hasta){

                    $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                    $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                    $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                            FROM `registro_portales`
                            WHERE `id_cliente` = ".$id_cliente.
                            " AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y')
                            GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                }else
                    if($req->desde){

                        $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                        $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                FROM `registro_portales`
                                WHERE `id_cliente` = ".$id_cliente.
                                " AND date_format(`fecha_registro`,'%m-%d-%Y')  > date_format( '".$req->desde."' ,'%m-%d-%Y') 
                                GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                    }else
                        if($req->hasta){

                            $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                            $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_portales`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND date_format(`fecha_registro`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                        }else{
                            $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_portales`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format(now()-interval 7 day,'%m-%d-%Y') and date_format(now(),'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                        }

                
            
                $results = DB::select($sql);

                return $results;


            }else
                return "El id del usuario '".$user->username."' no se encuentra en tabla clientes";
        }
    }

    //Registros Usuarios PortalHook
    public function portalhookuserreg()
    {
        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = $this->getclientes();

        return view('graphics/portalhookuserreg',compact('clientes'));
    }

    //Registros Usuarios PortalHook
    public function getportalhookuserreg()
    {
        if(Request::ajax()){

            $req = Request::all();

            $req = json_encode($req);

            $req = json_decode($req);

            $user=Auth::user();
            
            $sql1 = "SELECT id_cliente
                    FROM clientes
                    WHERE id_usuario_web =".$user->id_usuario_web;

            $rows = DB::select($sql1);

            if(count($rows)){
                $id_cliente = $rows[0]->id_cliente;

                if($req->desde and $req->hasta){

                    $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                    $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                    $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                            FROM `registro_usuarios_ph`
                            WHERE `id_cliente` = ".$id_cliente.
                            " AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y') 
                            GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                    $sql1 = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                            FROM `registro_portales`
                            WHERE `id_cliente` = ".$id_cliente.
                            " AND `id_usuario_ph` IS NULL
                            AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y') 
                            GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                }else
                    if($req->desde){

                        $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                        $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                FROM `registro_usuarios_ph`
                                WHERE `id_cliente` = ".$id_cliente.
                                " AND date_format(`fecha_registro`,'%m-%d-%Y')  > date_format( '".$req->desde."' ,'%m-%d-%Y') 
                                GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                        $sql1 = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                FROM `registro_portales`
                                WHERE `id_cliente` = ".$id_cliente.
                                " AND `id_usuario_ph` IS NULL
                                AND date_format(`fecha_registro`,'%m-%d-%Y')  > date_format( '".$req->desde."' ,'%m-%d-%Y') 
                                GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                    }else
                        if($req->hasta){

                            $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                            $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_usuarios_ph`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND date_format(`fecha_registro`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                            $sql1 = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_portales`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND `id_usuario_ph` IS NULL
                                    AND date_format(`fecha_registro`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y') 
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                        }else{
                            $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_usuarios_ph`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format(now()-interval 7 day,'%m-%d-%Y') and date_format(now(),'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                            $sql1 = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_portales`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND `id_usuario_ph` IS NULL
                                    AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format(now()-interval 7 day,'%m-%d-%Y') and date_format(now(),'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                        }
            
                $results = DB::select($sql);

                $results1 = DB::select($sql1);

                $array = array($results, $results1);

                return $array;
                
            }else
                return "El id del usuario '".$user->username."' no se encuentra en tabla clientes";
        }
    }

    //Registros Usuarios PortalHook Hombres y Mujeres
    public function sexportalhookuserreg()
    {
        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = $this->getclientes();

        return view('graphics/sexportalhookuserreg',compact('clientes'));
    }

    public function getsexportalhookuserreg()
    {
        if(Request::ajax()){

            $req = Request::all();

            $req = json_encode($req);

            $req = json_decode($req);

            $user=Auth::user();
            
            $sql1 = "SELECT id_cliente
                    FROM clientes
                    WHERE id_usuario_web =".$user->id_usuario_web;

            $rows = DB::select($sql1);

            if(count($rows)){
                $id_cliente = $rows[0]->id_cliente;

                
                if($req->desde and $req->hasta){

                    $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                    $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                    $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                            FROM `registro_usuarios_ph`
                            WHERE `id_cliente` = ".$id_cliente.
                            " AND `sex` = 'M' 
                            AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y') 
                            GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                    $sql1 = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                            FROM `registro_usuarios_ph`
                            WHERE `id_cliente` = ".$id_cliente.
                            " AND `sex` = 'F' 
                            AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y') 
                            GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                }else
                    if($req->desde){

                        $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                        $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                FROM `registro_usuarios_ph`
                                WHERE `id_cliente` = ".$id_cliente.
                                " AND `sex` = 'M' 
                                AND date_format(`fecha_registro`,'%m-%d-%Y')  > date_format( '".$req->desde."' ,'%m-%d-%Y') 
                                GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                        $sql1 = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                FROM `registro_usuarios_ph`
                                WHERE `id_cliente` = ".$id_cliente.
                                " AND `sex` = 'F' 
                                AND date_format(`fecha_registro`,'%m-%d-%Y')  > date_format( '".$req->desde."' ,'%m-%d-%Y') 
                                GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                    }else
                        if($req->hasta){

                            $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');
                        
                            $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_usuarios_ph`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND `sex` = 'M' 
                                    AND date_format(`fecha_registro`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                            $sql1 = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_usuarios_ph`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND `sex` = 'F' 
                                    AND date_format(`fecha_registro`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                        }else{
                            $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_usuarios_ph`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND `sex` = 'M' 
                                    AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format(now()-interval 7 day,'%m-%d-%Y') and date_format(now(),'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                            $sql1 = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_usuarios_ph`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND `sex` = 'F' 
                                    AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format(now()-interval 7 day,'%m-%d-%Y') and date_format(now(),'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                        }
            
                $results = DB::select($sql);

                $results1 = DB::select($sql1);

                $array = array($results, $results1);

                return $array;


            }else
                return "El id del usuario '".$user->username."' no se encuentra en tabla clientes";
        }
    }

}
