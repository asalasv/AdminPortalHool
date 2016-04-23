<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; 
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
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

    	$data = array();

    	$sql = "SELECT u.email, u.nombre, u.apellido, u.birthday, u.sex, r.fecha_registro, a.tipo_dispositivo, a.modelo, a.so_dispositivo, a.navegador, a.resumen
				FROM  `usuarios_ph` u,  `registro_portales` r,  `actividad_portales` a
				WHERE r.id_cliente =".$id_cliente.
				" AND u.id_usuario_ph = r.id_usuario_ph
				AND a.mac = r.mac";

		$results = \DB::select($sql);

		$results = json_decode(json_encode($results), True);

        //$default = ini_get('max_execution_time');
        //set_time_limit(1000);
        

		Excel::create('BD_PortalHook', function($excel) use($results) {
			    // Set the title
			    $excel->setTitle('Base de datos PortalHook');

			    // Chain the setters
			    $excel->setCreator('PortalHook')
			          ->setCompany('PortalHook');

		    $excel->sheet('Sheetname', function($sheet) use($results) {

		        $sheet->fromArray($results);

		    });

		})->export('xls');

		return view('home');
        //set_time_limit($default);
    }


}
