<?php

namespace App\Http\Controllers\CentroMedico\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CentroMedico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ConfiguracionCentroController extends Controller
{
    /**
     * Mostrar formulario de configuración del centro médico.
     */
    public function index()
    {
        $centroMedico = Auth::user()->centroMedico;

        if (!$centroMedico) {
            abort(404, 'Centro Médico no encontrado.');
        }

        Log::info("Cargando configuración del centro médico ID: {$centroMedico->id_centro}");

        return view('admin.centro.configurar.configurar', compact('centroMedico'));
    }

    /**
     * Actualizar los datos del centro médico.
     */
    public function update(Request $request)
{
    $centroMedico = Auth::user()->centroMedico;

    if (!$centroMedico) {
        abort(404, 'Centro Médico no encontrado.');
    }

    $request->validate([
        'nombre' => 'required|string|max:255',
        'direccion' => 'nullable|string|max:255',
        'ruc' => 'nullable|string|max:11',
        'color_tema' => 'nullable|string|size:7|regex:/^#[a-fA-F0-9]{6}$/',
        'logo' => 'nullable|image|max:2048', // 2MB máximo
    ]);

    Log::info("Actualizando datos del centro médico ID: {$centroMedico->id_centro}");

    // Verificar si se subió un nuevo logo
    if ($request->hasFile('logo')) {
        // Eliminar el logo anterior si existe
        if ($centroMedico->logo && Storage::disk('public')->exists($centroMedico->logo)) {
            Storage::disk('public')->delete($centroMedico->logo);
        }

        // Guardar el nuevo logo en storage/app/public/logos
        $logoPath = $request->file('logo')->store('logos', 'public');

        // Copiar el logo a public/storage/logos
        $sourcePath = storage_path('app/public/' . $logoPath);
        $destinationPath = public_path('storage/' . $logoPath);

        if (!file_exists(dirname($destinationPath))) {
            mkdir(dirname($destinationPath), 0777, true);
        }

        copy($sourcePath, $destinationPath);

        $centroMedico->logo = $logoPath;
    }

    $centroMedico->nombre = $request->nombre;
    $centroMedico->direccion = $request->direccion;
    $centroMedico->ruc = $request->ruc;
    $centroMedico->color_tema = $request->color_tema;

    $centroMedico->save();

    Log::info("Datos del centro médico ID: {$centroMedico->id_centro} actualizados exitosamente.");

    return redirect()->route('configurar.centro')->with('success', 'Centro médico actualizado correctamente.');
}

}
