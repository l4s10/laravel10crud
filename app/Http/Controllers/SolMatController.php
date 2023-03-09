<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudMateriales;

class SolMatController extends Controller
{
    //Funcion para acceder a las rutas SOLO SI los usuarios estan logueados
    public function __cosntruct(){
        $this->middleware('auth');
        //Tambien aqui podremos agregar que roles son los que pueden ingresar
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Obtenemos todos los datos de la tabla de solicitudes para mostrarlas en el index
        $sol_materiales = SolicitudMateriales::all();
        return view('solicitudmateriales.index',compact('sol_materiales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('solicitudmateriales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}