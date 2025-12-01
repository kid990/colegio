<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use App\Models\Nivel;
use Illuminate\Http\Request;

class GradoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grados=Grado::paginate(5);
        $niveles=Nivel::all();

        return view('admin.grado.index',compact('grados','niveles'));

    }

    
    public function store(Request $request)
    {
        //
        $data=$request->validate([
            'nombre'=>'required|unique:grados,nombre',
            'nivel_id'=>'required|exists:nivels,id',
        ]);

        Grado::create($data);
        return redirect()->route('grados.index')->with('success','Grado creado con exito');
    }

    
    public function update(Request $request, Grado $grado)
    {
        //
        $data=$request->validate([
            'nombre'=>'required|unique:grados,nombre,' .$grado->id,
            'nivel_id'=>'required|exists:nivels,id',
        ]);

        $grado->update($data);
        return redirect()->route('grados.index')->with('success','Grado actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grado $grado)
    {
        //
        $grado->delete();
        return redirect()->route('grados.index')->with('success','Grado eliminado con exito');
    }
}
