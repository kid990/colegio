<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\json;

class ConfiguracionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $jsonData = file_get_contents('https://api.hilariweb.com/divisas');
        $divisas = json_decode($jsonData, true);

        $configuracion = Configuracion::first();

        return view('admin.configuracion.index', compact('configuracion', 'divisas'));
    }

  
    public function store(Request $request)
    {
        // Ver si ya existe una configuración
        $configuracion = Configuracion::first();

        // Reglas base
        $rules = [
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'descripcion' => 'required|string|max:500',
            'telefono' => 'required|string|max:20',
            'divisa' => 'required|string|max:10',
            'correo_electronico' => 'required|email|max:255',
            'web' => 'nullable|string|max:255',
            'logo' => 'nullable|mimes:jpeg,png,jpg,svg|max:10048',
        ];

        // Si no existe configuración previa, el logo es obligatorio
        if (!$configuracion) {
            $rules['logo'] = 'required|mimes:jpeg,png,jpg,svg|max:10048';
        }

        // Validación
        $request->validate($rules);

        // Tomar solo campos de texto
        $data = $request->only([
            'nombre',
            'direccion',
            'descripcion',
            'telefono',
            'divisa',
            'correo_electronico',
            'web',
        ]);

        // Manejo del logo
        if ($request->hasFile('logo')) {
            // Guardar nuevo logo
            $nuevoLogo = $request->file('logo')->store('logo', 'public');

            // Borrar logo anterior si existe
            if ($configuracion && $configuracion->logo) {
                Storage::disk('public')->delete($configuracion->logo);
            }

            $data['logo'] = $nuevoLogo;
        } else {
            // Si no se sube logo nuevo pero ya había uno, se mantiene
            if ($configuracion) {
                $data['logo'] = $configuracion->logo;
            }
        }

        // Crear o actualizar según exista o no
        if ($configuracion) {
            $configuracion->update($data);
            $mensaje = 'Configuración actualizada exitosamente';
        } else {
            Configuracion::create($data);
            $mensaje = 'Configuración guardada exitosamente';
        }

        return redirect()
            ->back()
            ->with('success', $mensaje);
    }


    /**
     * Display the specified resource.
     */
    public function show(Configuracion $configuracion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Configuracion $configuracion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Configuracion $configuracion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Configuracion $configuracion)
    {
        //
    }
}
