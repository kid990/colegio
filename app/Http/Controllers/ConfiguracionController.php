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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $configuracion = Configuracion::first();

        $rules = [
            'nombre' => 'required',
            'direccion' => 'required',
            'descripcion' => 'required',
            'telefono' => 'required',
            'divisa' => 'required',
            'correo_electronico' => 'required|email',
            'web' => '',
            'logo' => 'nullable|mimes:jpeg,png,jpg,svg|max:10048',
        ];

        // Si no existe configuración previa, el logo es obligatorio
        if (!$configuracion) {
            $rules['logo'] = 'required|mimes:jpeg,png,jpg,svg|max:10048';
        }
        $request->validate($rules);
        // Preparar datos para guardar

        // Método 1: Toma TODO del request
        // $data = $request->all();

        // Método 2: Toma TODO excepto el logo (luego lo agregamos manualmente)
        $data = $request->except('logo');

        // Método 3: Toma solo los campos específicos
        // $data = $request->only(['nombre', 'direccion', 'descripcion', 'telefono', 'divisa', 'correo_electronico', 'web']);

        // Manejo del logo
        if ($request->hasFile('logo')) {
            $nuevoLogo = $request->file('logo')->store('logo', 'public');

            // DESPUÉS: Borrar logo anterior si existe
            if ($configuracion && $configuracion->logo) {
                Storage::disk('public')->delete($configuracion->logo);
            }
            $data['logo'] = $nuevoLogo;

        } else {
            if ($configuracion) {
                $data['logo'] = $configuracion->logo;

            }

        }
        if($configuracion){
            $configuracion->update($data);
            return redirect()->back()->with('success', 'Configuración actualizado exitosamente');
        }else{
            Configuracion::create($data);
            return redirect()->back()->with('success', 'Configuración guardada exitosamente');
        };


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
