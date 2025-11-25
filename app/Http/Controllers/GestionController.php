<?php

namespace App\Http\Controllers;

use App\Models\Gestion;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class GestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $gestiones = Gestion::all();
        return view('admin.gestion.index', compact('gestiones'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('admin.gestion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nombre' => 'required|unique:gestions|max:255',
        ]);


        Gestion::create($request->all());
        return redirect()->route('gestion.index')->with('success', 'Gestion agregada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gestion $gestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gestion $gestion)
    {
        //


        return view('admin.gestion.edit', compact('gestion'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gestion $gestion)
    {
        //

        $request->validate([
            'nombre' => 'required|unique:gestions,nombre,'.$gestion->id,
        ]);

        $gestion->update($request->all());
        return redirect()->route('gestion.index')->with('success', 'Gestion actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gestion $gestion)
    {
        //
        $gestion->delete();
        return redirect()->route('gestion.index')->with('success', 'Gestion eliminada correctamente');
    }
}
