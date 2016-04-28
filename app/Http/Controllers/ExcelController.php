<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; 
use App\Http\Requests;
use App\Cliente;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class ExcelController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIdcliente(){

        return Session::get('client.id_cliente');

    }
    
    public function index(){

        if($this->getIdcliente() == null ){
            return redirect('home');
        }

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
