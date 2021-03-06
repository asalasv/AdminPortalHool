<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Portal;

use Illuminate\Support\Facades\Session;

use App\Http\Requests;

class ClientesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function select($id){

        Session::forget('portal.logo');

        $portal = Portal::where('id_cliente', $id)->where('predeterminado', 'V')->first();

        $cliente = Cliente::findOrFail($id);

        if($portal){
            if($portal->imagen_logo){
                Session::put('portal.logo',"/images/".$portal->imagen_logo);
            }
        }
        Session::put('client.id_cliente',$id);
        Session::put('client.name',$cliente->nombre);
        Session::put('activo','1');
        return 'Cliente seleccionado';
    }   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
