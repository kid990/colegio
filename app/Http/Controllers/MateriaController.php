<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $materias = Materia::paginate(10);
        return view('admin.materia.index', compact('materias'));
    }

    
    public function store(Request $request)
    {
        //

        $data=$request->validate([
            'nombre'=>'required|unique:materias,nombre'
        ]);

        Materia::create($data);

        return redirect()->route('materias.index')->with('success', 'Materia creada exitosamente');
    }

    
    public function update(Request $request, Materia $materia)
    {
        $data=$request->validate([
            'nombre'=>'required|unique:materias,nombre,'.$materia->id
        ]);

        $materia->update($data);

        return redirect()->route('materias.index')->with('success', 'Materia actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materia $materia)
    {
        //
        $materia->delete();

        return redirect()->route('materias.index')->with('success', 'Materia eliminada exitosamente');
    }
}
