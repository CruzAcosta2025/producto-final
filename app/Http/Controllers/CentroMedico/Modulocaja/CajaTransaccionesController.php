<?php

namespace App\Http\Controllers\CentroMedico\Modulocaja;

use App\Http\Controllers\Controller;
use App\Models\Caja;
use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CajaTransaccionesController extends Controller
{

    /**
     * Sincronizar transacciones desde facturas con estado PAGADA.
     */
    public function sincronizarTransaccionesDesdeFacturas()
    {
        Log::info('Sincronizando transacciones desde facturas PAGADAS.');

        $facturas = Factura::where('estado_pago', 'PAGADA')
            ->where('id_centro', Auth::user()->id_centro)
            ->doesntHave('caja') // Solo facturas sin transacción registrada
            ->get();

        foreach ($facturas as $factura) {
            Caja::create([
                'id_centro' => $factura->id_centro,
                'id_factura' => $factura->id_factura,
                'fecha_transaccion' => $factura->fecha_factura,
                'monto' => $factura->total,
                'tipo_transaccion' => 'INGRESO',
                'descripcion' => "Ingreso por factura #{$factura->id_factura}",
            ]);
        }

        Log::info('Sincronización completada.');

        return redirect()->route('modulocaja.index')->with('success', 'Transacciones sincronizadas correctamente.');
    }


    /**
     * Mostrar el listado de transacciones de caja.
     */
    public function index(Request $request)
    {
        Log::info('Cargando listado de transacciones de caja.');

        $tipoTransaccion = $request->input('tipo_transaccion');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $transacciones = Caja::where('id_centro', Auth::user()->id_centro);

        if ($tipoTransaccion) {
            $transacciones->where('tipo_transaccion', $tipoTransaccion);
        }

        if ($fechaInicio) {
            $transacciones->where('fecha_transaccion', '>=', $fechaInicio);
        }

        if ($fechaFin) {
            $transacciones->where('fecha_transaccion', '<=', $fechaFin);
        }

        $transacciones = $transacciones->orderBy('fecha_transaccion', 'desc')->paginate(10);

        return view('admin.centro.modulocaja.index', compact('transacciones', 'tipoTransaccion', 'fechaInicio', 'fechaFin'));
    }

    /**
     * Mostrar el formulario para registrar una nueva transacción.
     */
    public function create()
    {
        Log::info('Mostrando formulario de registro de nueva transacción.');
        return view('admin.centro.modulocaja.create');
    }

    /**
     * Guardar una nueva transacción en la base de datos.
     */
    public function store(Request $request)
    {
        Log::info('Procesando nueva transacción de caja.');

        $request->validate([
            'tipo_transaccion' => 'required|in:INGRESO,EGRESO',
            'monto' => 'required|numeric|min:0.01',
            'descripcion' => 'nullable|string|max:255',
        ]);

        Caja::create([
            'id_centro' => Auth::user()->id_centro,
            'fecha_transaccion' => now(),
            'tipo_transaccion' => $request->tipo_transaccion,
            'monto' => $request->monto,
            'descripcion' => $request->descripcion,
        ]);

        Log::info('Transacción registrada exitosamente.');
        return redirect()->route('modulocaja.index')->with('success', 'Transacción registrada correctamente.');
    }

    /**
     * Mostrar el formulario para editar una transacción existente.
     */
    public function edit($id)
    {
        Log::info("Cargando formulario de edición para la transacción con ID: $id.");

        $transaccion = Caja::where('id_centro', Auth::user()->id_centro)->findOrFail($id);

        return view('admin.centro.modulocaja.edit', compact('transaccion'));
    }

    /**
     * Actualizar una transacción en la base de datos.
     */
    public function update(Request $request, $id)
    {
        Log::info("Procesando actualización de transacción con ID: $id.");

        $request->validate([
            'tipo_transaccion' => 'required|in:INGRESO,EGRESO',
            'monto' => 'required|numeric|min:0.01',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $transaccion = Caja::where('id_centro', Auth::user()->id_centro)->findOrFail($id);

        $transaccion->update([
            'tipo_transaccion' => $request->tipo_transaccion,
            'monto' => $request->monto,
            'descripcion' => $request->descripcion,
        ]);

        Log::info('Transacción actualizada exitosamente.');
        return redirect()->route('modulocaja.index')->with('success', 'Transacción actualizada correctamente.');
    }

    /**
     * Eliminar una transacción.
     */
    public function destroy($id)
    {
        Log::info("Procesando eliminación de transacción con ID: $id.");

        $transaccion = Caja::where('id_centro', Auth::user()->id_centro)->findOrFail($id);
        $transaccion->delete();

        Log::info('Transacción eliminada exitosamente.');
        return redirect()->route('modulocaja.index')->with('success', 'Transacción eliminada correctamente.');
    }
}
