<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $turnos = Turno::paginate(10);
        return view("admin.turno.index", compact('turnos'));
    }

    /**
     * Show the form for creating a new resource.
     */


    public function store(Request $request)
    {
        //
         $datos = request()->validate([
            'nombre' => 'required|string|min:3|max:100|unique:turnos,nombre',
        ]);

        Turno::create($datos);

        return redirect()
            ->route('turno.index')
            ->with('success', 'turno creado correctamente.');
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Turno $turno)
    {
        //
        $tdatos = $request->validate([
            'nombre' => 'required|string|max:100|unique:turnos,nombre,' . $turno->id,
        ]);

        $turno->update($tdatos);

        return redirect()
            ->route('turno.index')
            ->with('success', 'Turno actualizado correctamente.');


    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turno $turno)
    {
        //

        $turno->delete();

        return redirect()
            ->route('turno.index')
            ->with('success', 'Turno eliminado correctamente.');


    }
}
