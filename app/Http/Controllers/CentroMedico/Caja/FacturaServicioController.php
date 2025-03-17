<?php

namespace App\Http\Controllers\CentroMedico\Caja;

use App\Http\Controllers\Controller;
use App\Models\FacturaServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FacturaServicioController extends Controller
{
    public function update(Request $request, $id)
    {
        try {
            Log::info('Datos recibidos en FacturaServicioController@update:', $request->all());

            $request->validate([
                'cantidad' => 'required|integer|min:1',
            ]);

            $facturaServicio = FacturaServicio::findOrFail($id);
            $facturaServicio->cantidad = $request->cantidad;
            $facturaServicio->subtotal = $facturaServicio->servicio->precio * $request->cantidad;
            $facturaServicio->save();

            Log::info('Factura servicio actualizado con éxito:', $facturaServicio->toArray());

            return redirect()->back()->with('success', 'Servicio actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error("Error en FacturaServicioController@update: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'Error al actualizar el servicio.']);
        }
    }

    public function destroy($id)
    {
        try {
            Log::info("Eliminando servicio con ID: {$id}");

            $facturaServicio = FacturaServicio::findOrFail($id);
            $facturaServicio->delete();

            Log::info('Servicio eliminado con éxito.');

            return redirect()->back()->with('success', 'Servicio eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error("Error en FacturaServicioController@destroy: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'Error al eliminar el servicio.']);
        }
    }
}
