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
    
    public function imgpublicidad()
    {

        $id_cliente = $this->getIdcliente();

        $sql = "SELECT imagen_publicidad
        FROM portales_cliente 
        WHERE id_cliente =".$id_cliente;

        $result = \DB::select($sql);

        $publicidad = base64_encode($result[0]->imagen_publicidad);   

        $publicidad = 'data:image/png;base64,'.$publicidad;

        return view('portal/publicidad',compact('publicidad'));
    }

    public function imglogo()
    {

        $id_cliente = $this->getIdcliente();

        $sql = "SELECT imagen_logo
        FROM portales_cliente 
        WHERE id_cliente =".$id_cliente;

        $result = \DB::select($sql);

        $logo = base64_encode($result[0]->imagen_logo);   

        $logo = 'data:image/png;base64,'.$logo;

        return view('portal/logo',compact('logo'));
    }

    public function updateimglogo(Request $request)
    {

        $id_cliente = $this->getIdcliente();

        if($id_cliente){

            foreach ($request->only('logo') as $logo) {

                if($logo){

                    $id_cliente = $this->getIdcliente();

                    $fp      = fopen($logo->getRealPath(), 'r');
                    $image = fread($fp, filesize($logo->getRealPath()));
                    $image = addslashes($image);
                    fclose($fp);

                    $sql = "UPDATE portales_cliente 
                    SET imagen_logo = '".$image."' 
                    WHERE  id_cliente =".$id_cliente;

                    $result = \DB::statement($sql);

                    return $this->imglogo();

                }else
                return $this->imglogo();

            }

            return view('portal/logo');

        }else
        return view('portal/logo');

        

    }

    public function updateimgpublicidad(Request $request)
    {

        $id_cliente = $this->getIdcliente();

        if($id_cliente){

            foreach ($request->only('publicidad') as $publicidad) {

                if($publicidad){

                    $id_cliente = $this->getIdcliente();

                    $fp      = fopen($publicidad->getRealPath(), 'r');
                    $image = fread($fp, filesize($publicidad->getRealPath()));
                    $image = addslashes($image);
                    fclose($fp);

                    $sql = "UPDATE portales_cliente 
                    SET imagen_publicidad = '".$image."' 
                    WHERE  id_cliente =".$id_cliente;

                    $result = \DB::statement($sql);

                    return $this->imgpublicidad();

                }else
                return $this->imgpublicidad();

            }

            return view('portal/publicidad');
            

        }else
        return view('portal/publicidad');


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


            $portal->hora_inicio = $request->fecha_inicio.' '.$request->hora_inicio.':00';
            $portal->hora_fin = $request->fecha_fin.' '.$request->hora_fin.':00';

            foreach ($request->only('imagen_publicidad') as $publicidad) {
                if($publicidad){
                    if($publicidad->isValid()){
                        // if($portal->imagen_publicidad != null){
                        //     unlink($portal->imagen_publicidad);
                        // }
                        $filename = $publicidad->getClientOriginalName();
                        $path = "storage/".$this->getIdcliente().'/'.$portal->descripcion.'/publicidad';
                        $publicidad->move($path, $filename);
                        chmod($path . "/" . $filename, 0777);
                        $portal->imagen_publicidad = $path . "/" . $filename;
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
                        $filename = $logo->getClientOriginalName();
                        $path = "storage/".$this->getIdcliente().'/'.$portal->descripcion.'/logo';
                        $logo->move($path, $filename);
                        chmod($path . "/" . $filename, 0777);
                        $portal->imagen_logo = $path . "/" . $filename;
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
                    $filename = $fondo->getClientOriginalName();
                    $path = "storage/".$this->getIdcliente().'/'.$portal->descripcion.'/fondo';
                    $fondo->move($path, $filename);
                    chmod($path . "/" . $filename, 0777);
                    $portal->imagen_fondo = $path . "/" . $filename;
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

        $newportal->hora_inicio = $request->fecha_inicio.' '.$request->hora_inicio.':00';
        $newportal->hora_fin = $request->fecha_fin.' '.$request->hora_fin.':00';

        foreach ($request->only('imagen_publicidad') as $publicidad) {
            if($publicidad){
                if($publicidad->isValid()){
                    $filename = $publicidad->getClientOriginalName();
                    $path = "storage/".$this->getIdcliente().'/'.$newportal->descripcion.'/publicidad';
                    $publicidad->move($path, $filename);
                    chmod($path . "/" . $filename, 0777);
                    $newportal->imagen_publicidad = $path . "/" . $filename;
                }
            }
            break;
        }

        foreach ($request->only('imagen_logo') as $logo) {
            if($logo){
                if($logo->isValid()){
                    $filename = $publicidad->getClientOriginalName();
                    $path = "storage/".$this->getIdcliente().'/'.$newportal->descripcion.'/logo';
                    $logo->move($path, $filename);
                    chmod($path . "/" . $filename, 0777);
                    $newportal->imagen_logo = $path . "/" . $filename;
                }
            }
            break;
        }

        foreach ($request->only('imagen_fondo') as $fondo) {
            if($fondo){
                if($fondo->isValid()){
                    $filename = $publicidad->getClientOriginalName();
                    $path = "storage/".$this->getIdcliente().'/'.$newportal->descripcion.'/fondo';
                    $fondo->move($path, $filename);
                    chmod($path . "/" . $filename, 0777);
                    $newportal->imagen_fondo = $path . "/" . $filename;
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
