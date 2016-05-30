<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; 
use App\Portal;
use App\Cliente;
use App\Quotation;
use DB;
use Illuminate\Support\Facades\Session;


use Illuminate\Support\Collection as Collection;
use App\Http\Controllers\Controller;

class PortalesController extends Controller
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

    public function index()
    {
        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $id_cliente = $this->getIdcliente();

        $clientes = $this->getclientes();

        $portales = Portal::where('id_cliente', $id_cliente)->paginate(15);

        return view('portales/portales',compact('portales', 'clientes'));
    }

    public function newportal(Request $request){
        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = $this->getclientes();

        return view('portales/newportal',compact('clientes'));
        
    }

    public function editportal($id_portal_cliente, Request $request){

        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $portal = Portal::findOrFail($id_portal_cliente);

        $clientes = $this->getclientes();

        return view('portales/editportal',compact('portal','clientes'));
    }

    public function update($id_portal_cliente, Request $request){

            $portal = Portal::findOrFail($id_portal_cliente);

            $portal->fill($request->all());

            if($request->predeterminado == 'on'){

                // recorrer todos los portales clientes y ponerlos en falso a todoso
                $portales = Portal::where('id_cliente', '=', $portal->id_cliente)->get();

                foreach ($portales as $p) {
                    if($p->id_portal_cliente != $portal->id_portal_cliente){
                        $p->predeterminado = 'F';
                        $p->save();
                    }
                }

                $portal->predeterminado = 'V';

                $portal->fecha_inicio = '';
                $portal->fecha_fin = '';
                $portal->hora_inicio = '';
                $portal->hora_fin = '';
                $portal->save();


            }else{
                $portal->predeterminado = 'F';
                $portal->hora_inicio = $request->hora_inicio;
                $portal->hora_fin = $request->hora_fin;
            }

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

        if($portal->predeterminado == 'F'){

            $hora_inic = new \DateTime($portal->hora_inicio);
            $hourString = $hora_inic->format('H');

            $minuteString = $hora_inic->format('i');

            $fecha_inic = new \DateTime($portal->fecha_inicio);
            $yearString = $fecha_inic->format('Y');
            $monthString = $fecha_inic->format('m');
            $dayString = $fecha_inic->format('d');

            shell_exec('./script.sh '.$portal->id_cliente.' '.$minuteString.' '.$hourString.' '.$dayString.' '.$monthString.' '.$portal->id_portal_cliente);

            $hora_fin = new \DateTime($portal->hora_fin);
            $hourString = $hora_fin->format('H');
            $minuteString = $hora_fin->format('i');

            $fecha_fin = new \DateTime($portal->fecha_fin);
            $yearString = $fecha_fin->format('Y');
            $monthString = $fecha_fin->format('m');
            $dayString = $fecha_fin->format('d');

            shell_exec('./script.sh '.$portal->id_cliente.' '.$minuteString.' '.$hourString.' '.$dayString.' '.$monthString.' '.$portal->id_portal_cliente);

        }

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

            $portal->fecha_inicio = '';
            $portal->fecha_fin = '';
            $portal->hora_inicio = '';
            $portal->hora_fin = '';

        }else
            $newportal->predeterminado = 'F';

        $newportal->hora_inicio = $request->hora_inicio;
        $newportal->hora_fin = $request->hora_fin;

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

        if($newportal->predeterminado == 'F'){

            $hora_inic = new \DateTime($newportal->hora_inicio);
            $hourString = $hora_inic->format('H');

            $minuteString = $hora_inic->format('i');

            $fecha_inic = new \DateTime($newportal->fecha_inicio);
            $yearString = $fecha_inic->format('Y');
            $monthString = $fecha_inic->format('m');
            $dayString = $fecha_inic->format('d');

            shell_exec('./script.sh '.$newportal->id_cliente.' '.$minuteString.' '.$hourString.' '.$dayString.' '.$monthString.' '.$newportal->id_portal_cliente);

            $hora_fin = new \DateTime($newportal->hora_fin);
            $hourString = $hora_fin->format('H');
            $minuteString = $hora_fin->format('i');

            $fecha_fin = new \DateTime($newportal->fecha_fin);
            $yearString = $fecha_fin->format('Y');
            $monthString = $fecha_fin->format('m');
            $dayString = $fecha_fin->format('d');

            shell_exec('./script.sh '.$newportal->id_cliente.' '.$minuteString.' '.$hourString.' '.$dayString.' '.$monthString.' '.$newportal->id_portal_cliente);

        }

        return redirect('portales');
    }

    public function destroy($id_portal_cliente, Request $request){
            
        $portal = Portal::findOrFail($id_portal_cliente);

        $portal->delete();

        $message = 'El portal '. $portal->descripcion . " fue eliminado de nuestros registros";

        return $message;

    }

}
