<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use App\Models\Gestion;
use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periodos = Periodo::paginate(5);
        $gestiones=Gestion::all();

                   return view('admin.periodo.index', compact('periodos','gestiones'));


    }

    
    public function store(Request $request)
    {
        //

        $data = $request->validate([
            'nombre' => 'required|unique:periodos,nombre',
            'gestion_id' => 'required|exists:gestions,id'
        ]);

        Periodo::create($data);
        return redirect()->route('periodo.index')->with('success', 'Periodo creado con éxito');
    }

    /**
     * Display the specified resource.
     */
   
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Periodo $periodo)
    {
        $data = $request->validate([
            'nombre'=> 'required|unique:periodos,nombre,'. $periodo->nombre,
            'gestion_id' => 'required|exists:gestions,id,' 
        ]);

        $periodo->update($data);
        return redirect()->route('periodo.index')->with('success', 'Periodo actualizado con éxito');        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Periodo $periodo)
    {
        //
        $periodo->delete();
        return redirect()->route('periodo.index')->with('success', 'Periodo eliminado con éxito');
    }
}
