<?php

namespace App\Http\Controllers;

use App\Models\Nivel;
use Illuminate\Http\Request;

class NivelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Usamos paginación para que funcione $niveles->links()
        $niveles = Nivel::orderBy('id', 'desc')->paginate(10);

        return view('admin.nivel.index', compact('niveles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:nivels,nombre',
        ]);

        // Crear registro
        Nivel::create($validated);

        // Redirigir con mensaje
        return redirect()
            ->route('nivel.index')
            ->with('success', 'Nivel creado correctamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nivel $nivel)

    {


        // Validación (ignorando el mismo ID para el unique)
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:nivels,nombre,' . $nivel->id,
        ]);

        //dd($request->all());

        // Actualizar
        $nivel->update($validated);

        return redirect()
            ->route('nivel.index')
            ->with('success', 'Nivel actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nivel $nivel)
    {
        $nivel->delete();

        return redirect()
            ->route('nivel.index')
            ->with('success', 'Nivel eliminado correctamente.');
    }
}
