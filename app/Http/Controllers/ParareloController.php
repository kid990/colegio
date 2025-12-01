<?php

namespace App\Http\Controllers;

use App\Models\Pararelo;
use App\Models\Grado;
use Illuminate\Http\Request;

class ParareloController extends Controller
{
    
    public function index()
    {
        //
        $pararelos = Pararelo::orderBy('id','desc')->paginate(10);
        $grados = Grado::all();

        return view('admin.pararelo.index', compact('pararelos', 'grados'));
    }

    
    public function store(Request $request)
    {
        //
        $data=$request->validate([
            'nombre'=>'required|unique:pararelos,nombre',
            'grado_id'=>'required|exists:grados,id'
        ]);

        Pararelo::create($data);

        return redirect()->route('pararelos.index')->with('success', 'Pararelo creado exitosamente');
    }

   
    public function update(Request $request, Pararelo $pararelo)
    {
        //
        $data=$request->validate([
            'nombre'=>'required|unique:pararelos,nombre,' .$pararelo->id,
            'grado_id'=>'required|exists:grados,id'
        ]);

        $pararelo->update($data);

        return redirect()->route('pararelos.index')->with('success', 'Pararelo actualizado exitosamente');
    }

    
    public function destroy(Pararelo $pararelo)
    {
        //
        $pararelo->delete();

        return redirect()->route('pararelos.index')->with('success', 'Pararelo eliminado exitosamente');
    }
}
