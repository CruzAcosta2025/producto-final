<?php

namespace App\Http\Controllers\CentroMedico\Caja;

use App\Http\Controllers\Controller;
use App\Models\Factura;
use App\Models\FacturaServicio;
use App\Models\Paciente;
use App\Models\ServicioPrecio;
use App\Models\HorarioMedico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PersonalMedico;
use Illuminate\Pagination\LengthAwarePaginator;

class CajaController extends Controller
{


    public function generarFacturaGeneral(Request $request)
    {
        try {
            Log::info('Generar Factura General:', ['method' => $request->method()]);
            Log::info('Datos recibidos:', $request->all());

            $facturasSeleccionadas = explode(',', $request->input('facturas', ''));

            if (empty($facturasSeleccionadas)) {
                return redirect()->route('caja.index')->withErrors(['error' => 'No se seleccionaron facturas.']);
            }

            $facturas = Factura::whereIn('id_factura', $facturasSeleccionadas)
                ->where('id_centro', Auth::user()->id_centro)
                ->with(['paciente', 'servicios.servicio', 'personalMedico.usuario'])
                ->get();

            if ($facturas->isEmpty()) {
                return redirect()->route('caja.index')->withErrors(['error' => 'No se encontraron facturas válidas.']);
            }

            $tamaño = $request->input('tamaño', 'A4');

            // Validar tamaño seleccionado
            $tamañosPermitidos = [
                'A4' => [210, 297], // A4 en mm
                'A5' => [148, 210], // A5 en mm
                'Ticket' => [80, 200], // Ticket en mm
            ];

            if (!array_key_exists($tamaño, $tamañosPermitidos)) {
                $tamaño = 'A4'; // Valor predeterminado
            }

            $dimensiones = $tamañosPermitidos[$tamaño];

            $pdf = Pdf::loadView('admin.centro.caja.pdf.factura-general', compact('facturas'))
                ->setPaper([0, 0, $dimensiones[0] * 2.83465, $dimensiones[1] * 2.83465]); // Convertir mm a puntos

            $pdfBase64 = base64_encode($pdf->output());

            return view('admin.centro.caja.pdf.preview-factura-general', compact('facturas', 'pdfBase64', 'tamaño'));
        } catch (\Exception $e) {
            Log::error("Error en generarFacturaGeneral: {$e->getMessage()}");
            return redirect()->route('caja.index')->withErrors(['error' => 'No se pudo generar la factura general.']);
        }
    }



    public function descargarFacturaGeneral(Request $request)
    {
        try {
            Log::info('Iniciando descarga de factura general.');

            $facturasSeleccionadas = explode(',', $request->input('facturas', ''));

            if (empty($facturasSeleccionadas)) {
                return redirect()->route('caja.index')->withErrors(['error' => 'No se seleccionaron facturas.']);
            }

            $facturas = Factura::whereIn('id_factura', $facturasSeleccionadas)
                ->where('id_centro', Auth::user()->id_centro)
                ->with(['paciente', 'servicios.servicio', 'personalMedico.usuario'])
                ->get();

            if ($facturas->isEmpty()) {
                return redirect()->route('caja.index')->withErrors(['error' => 'No se encontraron facturas válidas.']);
            }

            foreach ($facturas as $factura) {
                if ($factura->estado_pago !== 'PAGADA') {
                    $factura->update(['estado_pago' => 'PAGADA']);
                }
            }

            $tamaño = $request->input('tamaño', 'A4');

            // Validar tamaño seleccionado
            $tamañosPermitidos = [
                'A4' => [210, 297], // A4 en mm
                'A5' => [148, 210], // A5 en mm
                'Ticket' => [80, 200], // Ticket en mm
            ];

            if (!array_key_exists($tamaño, $tamañosPermitidos)) {
                $tamaño = 'A4'; // Valor predeterminado
            }

            $dimensiones = $tamañosPermitidos[$tamaño];

            $pdf = Pdf::loadView('admin.centro.caja.pdf.factura-general', compact('facturas'))
                ->setPaper([0, 0, $dimensiones[0] * 2.83465, $dimensiones[1] * 2.83465]); // Convertir mm a puntos

            return $pdf->download('Factura-General.pdf');
        } catch (\Exception $e) {
            Log::error("Error en descargarFacturaGeneral: {$e->getMessage()}");
            return redirect()->route('caja.index')->withErrors(['error' => 'No se pudo descargar la factura general.']);
        }
    }


    public function verFactura(Request $request, $id)
    {
        try {
            $tamaño = $request->get('tamaño', 'A4'); // Tamaño predeterminado A4
            Log::info("Iniciando vista previa de factura con ID: {$id} y tamaño: {$tamaño}");

            // Consultar la factura y relaciones necesarias
            $factura = Factura::where('id_factura', $id)
                ->where('id_centro', Auth::user()->id_centro)
                ->with(['paciente', 'servicios.servicio', 'personalMedico.usuario'])
                ->firstOrFail();

            // Ajustar tamaños de papel
            $tamañosPermitidos = [
                'A4' => [210, 297], // A4 en mm
                'A5' => [148, 210], // A5 en mm
                'Ticket' => [80, 200], // Ticket en mm
            ];

            if (!array_key_exists($tamaño, $tamañosPermitidos)) {
                $tamaño = 'A4'; // Volver al tamaño predeterminado
            }

            // Configurar el tamaño en milímetros para DomPDF
            $dimensiones = $tamañosPermitidos[$tamaño];

            // Generar el PDF con el tamaño de papel dinámico
            $pdf = Pdf::loadView('admin.centro.caja.pdf.factura', compact('factura'))
                ->setPaper([0, 0, $dimensiones[0] * 2.83465, $dimensiones[1] * 2.83465]);

            // Convertir el PDF a una cadena base64 para mostrarlo en un iframe
            $pdfBase64 = base64_encode($pdf->output());

            return view('admin.centro.caja.pdf.preview', compact('factura', 'pdfBase64', 'tamaño'));
        } catch (\Exception $e) {
            Log::error("Error en CajaController@verFactura: {$e->getMessage()}");
            return redirect()->route('caja.index')->withErrors(['error' => 'No se pudo cargar la vista previa. Intente nuevamente.']);
        }
    }


    public function descargarFactura(Request $request, $id)
    {
        try {
            $tamaño = $request->get('tamaño', 'A4'); // Obtener el tamaño del papel (por defecto A4)
            Log::info("Iniciando descarga de factura con ID: {$id} y tamaño: {$tamaño}");

            // Consultar la factura y relaciones necesarias
            $factura = Factura::where('id_factura', $id)
                ->where('id_centro', Auth::user()->id_centro)
                ->with(['paciente', 'servicios.servicio', 'personalMedico.usuario'])
                ->firstOrFail();

            // Actualizar el estado de pago si no está pagada
            if ($factura->estado_pago !== 'PAGADA') {
                $factura->update(['estado_pago' => 'PAGADA']);
                Log::info("Estado de pago actualizado a PAGADA para la factura con ID: {$id}");
            }

            // Ajustar tamaños de papel
            $tamañosPermitidos = [
                'A4' => [210, 297], // A4 en mm
                'A5' => [148, 210], // A5 en mm
                'Ticket' => [80, 200], // Ticket en mm
            ];

            if (!array_key_exists($tamaño, $tamañosPermitidos)) {
                $tamaño = 'A4'; // Volver al tamaño predeterminado
            }

            // Configurar el tamaño en milímetros para DomPDF
            $dimensiones = $tamañosPermitidos[$tamaño];

            // Generar el PDF con el tamaño de papel dinámico
            $pdf = Pdf::loadView('admin.centro.caja.pdf.factura', compact('factura'))
                ->setPaper([0, 0, $dimensiones[0] * 2.83465, $dimensiones[1] * 2.83465]); // Convertir mm a puntos

            return $pdf->stream("Factura_{$factura->id_factura}.pdf");
        } catch (\Exception $e) {
            Log::error("Error en CajaController@descargarFactura: {$e->getMessage()}");
            return redirect()->route('caja.index')->withErrors(['error' => 'No se pudo generar la factura. Intente nuevamente.']);
        }
    }

    /**
     * Mostrar el listado de facturas con opción de búsqueda por DNI de paciente.
     */
    public function index(Request $request)
    {
        try {
            Log::info('Iniciando CajaController@index');

            $dni = $request->get('dni');
            $paciente = null;
            $facturas = null;

            if ($dni) {
                $paciente = Paciente::where('dni', $dni)
                    ->where('id_centro', Auth::user()->id_centro)
                    ->first();

                if ($paciente) {
                    $facturas = Factura::where('id_paciente', $paciente->id_paciente)
                        ->orderBy('fecha_factura', 'desc')
                        ->with(['paciente', 'personalMedico.usuario', 'usuario'])
                        ->paginate(10);
                }
            }

            // Si no hay facturas encontradas, crear un paginador vacío
            if (!$facturas) {
                $facturas = new LengthAwarePaginator([], 0, 10);
            }

            return view('admin.centro.caja.index', compact('facturas', 'paciente', 'dni'));
        } catch (\Exception $e) {
            Log::error('Error en CajaController@index: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Ocurrió un error al cargar las facturas.']);
        }
    }

    /**
     * Mostrar la vista para crear una nueva factura.
     */
    public function crearFactura(Request $request)
    {
        try {
            Log::info('Iniciando CajaController@crearFactura');

            $idPaciente = $request->get('id_paciente');

            $paciente = Paciente::where('id_paciente', $idPaciente)
                ->where('id_centro', Auth::user()->id_centro)
                ->firstOrFail();

            $servicios = ServicioPrecio::where('id_centro', Auth::user()->id_centro)
                ->where('estado', 'activo')
                ->get();

            $medicos = PersonalMedico::where('id_centro', Auth::user()->id_centro)
                ->with(['usuario', 'especialidad'])
                ->get();


            return view('admin.centro.caja.create-factura', compact('paciente', 'servicios', 'medicos'));
        } catch (\Exception $e) {
            Log::error('Error en CajaController@crearFactura: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Ocurrió un error al cargar el formulario de creación.']);
        }
    }

    /**
     * Almacenar una nueva factura con un único servicio y método de pago.
     */
    public function storeFactura(Request $request)
    {
        try {
            Log::info('Datos recibidos en storeFactura:', $request->all());

            $request->validate([
                'id_paciente' => 'required|exists:pacientes,id_paciente',
                'id_personal_medico' => 'required|exists:personal_medico,id_personal_medico',
                'id_servicio' => 'required|exists:servicios_precio,id_servicio',
                'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia',
            ]);

            $servicio = ServicioPrecio::where('id_servicio', $request->id_servicio)
                ->where('id_centro', Auth::user()->id_centro)
                ->firstOrFail();

            $subtotal = $servicio->precio;
            $impuesto = $subtotal * 0.18;
            $total = $subtotal + $impuesto;

            $factura = Factura::create([
                'id_paciente' => $request->id_paciente,
                'id_personal_medico' => $request->id_personal_medico,
                'id_centro' => Auth::user()->id_centro,
                'id_usuario' => Auth::id(),
                'subtotal' => $subtotal,
                'impuesto' => $impuesto,
                'total' => $total,
                'fecha_factura' => now(),
                'estado_pago' => 'PENDIENTE',
                'metodo_pago' => $request->metodo_pago,
            ]);

            FacturaServicio::create([
                'id_factura' => $factura->id_factura,
                'id_servicio' => $servicio->id_servicio,
                'cantidad' => 1,
                'subtotal' => $servicio->precio,
            ]);


            Log::info('Factura creada exitosamente:', $factura->toArray());

            return redirect()->route('caja.index')->with('success', 'Factura creada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error en CajaController@storeFactura: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Hubo un error al crear la factura. Intente nuevamente.']);
        }
    }

    /**
     * Editar una factura existente.
     */
    public function editarFactura($id)
    {
        try {
            Log::info('Iniciando CajaController@editarFactura');

            $factura = Factura::where('id_factura', $id)
                ->where('id_centro', Auth::user()->id_centro)
                ->with(['servicios.servicio', 'paciente', 'personalMedico'])
                ->firstOrFail();

            $servicios = ServicioPrecio::where('id_centro', Auth::user()->id_centro)
                ->where('estado', 'activo')
                ->get();

            $medicos = HorarioMedico::whereHas('personalMedico', function ($query) {
                $query->where('id_centro', Auth::user()->id_centro);
            })
                ->where('dia_semana', now()->locale('es')->isoFormat('dddd'))
                ->where('hora_inicio', '<=', now()->format('H:i'))
                ->where('hora_fin', '>=', now()->format('H:i'))
                ->with('personalMedico.usuario')
                ->get();

            return view('admin.centro.caja.edit-factura', compact('factura', 'servicios', 'medicos'));
        } catch (\Exception $e) {
            Log::error('Error en CajaController@editarFactura: ' . $e->getMessage());
            return redirect()->route('caja.index')->withErrors(['error' => 'Error al cargar la factura para editar.']);
        }
    }

    /**
     * Actualizar una factura existente con método de pago.
     */
    public function actualizarFactura(Request $request, $id)
    {
        try {
            Log::info('Datos recibidos en actualizarFactura:', $request->all());

            // Validar los campos
            $request->validate([
                'id_personal_medico' => 'required|exists:personal_medico,id_personal_medico',
                'id_servicio' => 'required|exists:servicios_precio,id_servicio',
                'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia',
                'estado_pago' => 'required|in:CANCELADO,PENDIENTE,PAGADA',
            ]);

            // Buscar la factura
            $factura = Factura::where('id_factura', $id)
                ->where('id_centro', Auth::user()->id_centro)
                ->with('servicios')
                ->firstOrFail();

            // Verificar si el servicio ha cambiado
            $servicioActual = $factura->servicios->first();
            if (!$servicioActual || $servicioActual->id_servicio != $request->id_servicio) {
                Log::info('Cambiando servicio de la factura.');

                // Obtener el nuevo servicio
                $nuevoServicio = ServicioPrecio::where('id_servicio', $request->id_servicio)
                    ->where('id_centro', Auth::user()->id_centro)
                    ->firstOrFail();

                // Actualizar o crear la relación de servicio en factura_servicios
                if ($servicioActual) {
                    $servicioActual->update([
                        'id_servicio' => $nuevoServicio->id_servicio,
                        'subtotal' => $nuevoServicio->precio,
                    ]);
                } else {
                    FacturaServicio::create([
                        'id_factura' => $factura->id_factura,
                        'id_servicio' => $nuevoServicio->id_servicio,
                        'cantidad' => 1,
                        'subtotal' => $nuevoServicio->precio,
                    ]);
                }

                // Recalcular subtotal, impuesto y total
                $factura->subtotal = $nuevoServicio->precio;
                $factura->impuesto = $nuevoServicio->precio * 0.18;
                $factura->total = $factura->subtotal + $factura->impuesto;
            }

            // Actualizar otros campos
            $factura->update([
                'id_personal_medico' => $request->id_personal_medico,
                'metodo_pago' => $request->metodo_pago,
                'estado_pago' => $request->estado_pago,
            ]);

            Log::info('Factura actualizada correctamente:', $factura->toArray());

            return redirect()->route('caja.index')->with('success', 'Factura actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error en CajaController@actualizarFactura: ' . $e->getMessage());
            return redirect()->route('caja.index')->withErrors(['error' => 'No se pudo actualizar la factura. Intente nuevamente.']);
        }
    }


    /**
     * Eliminar una factura existente.
     */
    public function eliminarFactura($id)
    {
        try {
            Log::info('Iniciando CajaController@eliminarFactura para ID:', ['id_factura' => $id]);

            $factura = Factura::where('id_factura', $id)
                ->where('id_centro', Auth::user()->id_centro)
                ->firstOrFail();

            FacturaServicio::where('id_factura', $factura->id_factura)->delete();
            $factura->delete();

            Log::info('Factura eliminada correctamente.');

            return redirect()->route('caja.index')->with('success', 'Factura eliminada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error en CajaController@eliminarFactura: ' . $e->getMessage());
            return redirect()->route('caja.index')->withErrors(['error' => 'No se pudo eliminar la factura.']);
        }
    }
}
