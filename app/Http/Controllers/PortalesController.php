<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; 
use App\Portal;
use App\Quotation;
use DB;



use Illuminate\Support\Collection as Collection;
use App\Http\Controllers\Controller;

class PortalesController extends Controller
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

    public function index()
    {
        $id_cliente = $this->getIdcliente();

        $portales = Portal::where('id_cliente', $id_cliente)->paginate(15);

        return view('portales/portales',compact('portales'));
    }

    public function newportal(Request $request){

        return view('portales/newportal');
        
    }

    public function editportal($id_portal_cliente, Request $request){

        $portal = Portal::findOrFail($id_portal_cliente);

        return view('portales/editportal',compact('portal'));
    }

        public function update($id_portal_cliente, Request $request){

            $portal = Portal::findOrFail($id_portal_cliente);

            $portal->fill($request->all());

            if($request->predeterminado == 'on'){

                // recorrer todos los portales clientes y ponerlos en falso a todoso
                $portales = Portal::where('id_cliente', '=', $portal->id_cliente)->get();

                foreach ($portales as $p) {
                    $p->predeterminado = 'F';
                    $p->save();
                }

                $portal->predeterminado = 'V';
            }else
            $portal->predeterminado = 'F';


            $portal->hora_inicio = $request->hora_inicio.':00';
            $portal->hora_fin = $request->hora_fin.':00';

            foreach ($request->only('imagen_publicidad') as $publicidad) {
                if($publicidad){
                    if($publicidad->isValid()){
                        // if($portal->imagen_publicidad != null){
                        //     unlink($portal->imagen_publicidad);
                        // }
                        $ext = $publicidad->getClientOriginalExtension();
                        $filename = uniqid().'.'.$ext;
                        $path = "images/";
                        $publicidad->move($path, $filename);
                        chmod($path . "/" . $filename, 0777);
                        $portal->imagen_publicidad = $filename;
                    }
                }
                break;
            }

            foreach ($request->only('imagen_logo') as $logo) {
                 if($logo){
                     if($logo->isValid()){
                        // if($portal->imagen_logo != null){
                        //     unlink($portal->imagen_logo);
                        // }
                        $ext = $logo->getClientOriginalExtension();
                        $filename = uniqid().'.'.$ext;
                        $path = "images/";
                        $logo->move($path, $filename);
                        chmod($path . "/" . $filename, 0777);
                        $portal->imagen_logo = $filename;
                    }
                }
                break;
            }

            foreach ($request->only('imagen_fondo') as $fondo) {
             if($fondo){
                if($fondo->isValid()){
                    // if($portal->imagen_fondo != null){
                    //     unlink($portal->imagen_fondo);
                    // }
                    $ext = $fondo->getClientOriginalExtension();
                    $filename = uniqid().'.'.$ext;
                    $path = "images/";
                    $fondo->move($path, $filename);
                    chmod($path . "/" . $filename, 0777);
                    $portal->imagen_fondo = $filename;
                }
            }
            break;
        }

        $portal->save();

        return redirect('portales');
    }

    public function store(Request $request){

        $newportal = new Portal($request->all());

        $newportal->id_cliente = $this->getIdcliente();

        if($request->predeterminado == 'on'){

                // recorrer todos los portales clientes y ponerlos en falso a todoso
            $portales = Portal::where('id_cliente', '=', $newportal->id_cliente)->get();

            foreach ($portales as $portal) {
                $portal->predeterminado = 'F';
                $portal->save();
            }

            $newportal->predeterminado = 'V';
        }else
        $newportal->predeterminado = 'F';

        $newportal->hora_inicio = $request->hora_inicio.':00';
        $newportal->hora_fin = $request->hora_fin.':00';

        foreach ($request->only('imagen_publicidad') as $publicidad) {
            if($publicidad){
                if($publicidad->isValid()){
                    $ext = $publicidad->getClientOriginalExtension();
                    $filename = uniqid().'.'.$ext;
                    $path = "images/";
                    $publicidad->move($path, $filename);
                    chmod($path . "/" . $filename, 0777);
                    $newportal->imagen_publicidad = $filename;
                }
            }
            break;
        }

        foreach ($request->only('imagen_logo') as $logo) {
            if($logo){
                if($logo->isValid()){
                    $ext = $logo->getClientOriginalExtension();
                    $filename = uniqid().'.'.$ext;
                    $path = "images/";
                    $logo->move($path, $filename);
                    chmod($path . "/" . $filename, 0777);
                    $newportal->imagen_logo = $filename;
                }
            }
            break;
        }

        foreach ($request->only('imagen_fondo') as $fondo) {
            if($fondo){
                if($fondo->isValid()){
                    $ext = $fondo->getClientOriginalExtension();
                    $filename = uniqid().'.'.$ext;
                    $path = "images/";
                    $fondo->move($path, $filename);
                    chmod($path . "/" . $filename, 0777);
                    $newportal->imagen_fondo = $filename;
                }
            }
            break;
        }

        $newportal->save();

        return redirect('portales');
    }

    public function destroy($id_portal_cliente, Request $request){
            
        $portal = Portal::findOrFail($id_portal_cliente);

        $portal->delete();

        $message = 'El portal '. $portal->descripcion . " fue eliminado de nuestros registros";

        return $message;

    }

}
