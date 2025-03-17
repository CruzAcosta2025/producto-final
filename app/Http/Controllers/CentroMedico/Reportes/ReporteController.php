<?php

namespace App\Http\Controllers\CentroMedico\Reportes;

use App\Http\Controllers\Controller;
use App\Models\Factura;
use App\Models\Caja;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function index()
    {
        $tiposReportes = [
            'Facturación' => 'Reporte de facturación por rango de fechas',
            'IngresosEgresos' => 'Reporte de ingresos y egresos por rango de fechas',
            'ServiciosMasSolicitados' => 'Servicios más solicitados',
            'PacientesAtendidos' => 'Pacientes atendidos por rango de fechas',
        ];

        return view('admin.centro.reportes.index', compact('tiposReportes'));
    }

    public function create($tipo)
    {
        $tiposValidos = ['Facturación', 'IngresosEgresos', 'ServiciosMasSolicitados', 'PacientesAtendidos'];

        if (!in_array($tipo, $tiposValidos)) {
            return redirect()->route('reportes.index')->withErrors(['error' => 'Tipo de reporte no válido.']);
        }

        return view('admin.centro.reportes.create', compact('tipo'));
    }

    public function store(Request $request, $tipo)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        switch ($tipo) {
            case 'Facturación':
                $facturas = Factura::where('id_centro', Auth::user()->id_centro)
                    ->whereBetween('fecha_factura', [$request->fecha_inicio, $request->fecha_fin])
                    ->with('paciente') // Carga el paciente relacionado
                    ->get();

                $totalFacturado = $facturas->sum('total');

                $contenido = [
                    'total_facturado' => $totalFacturado,
                    'detalle' => $facturas->map(function ($factura) {
                        return [
                            'fecha_factura' => $factura->fecha_factura,
                            'paciente' => $factura->paciente->nombre_completo ?? 'Paciente no registrado',
                            'total' => $factura->total,
                        ];
                    }),
                ];
                $descripcion = "Reporte de facturación del {$request->fecha_inicio} al {$request->fecha_fin}";
                break;

            case 'IngresosEgresos':
                $transacciones = Caja::where('id_centro', Auth::user()->id_centro)
                    ->whereBetween('fecha_transaccion', [$request->fecha_inicio, $request->fecha_fin])
                    ->get();

                $ingresos = $transacciones->where('tipo_transaccion', 'INGRESO')->sum('monto');
                $egresos = $transacciones->where('tipo_transaccion', 'EGRESO')->sum('monto');
                $ganancia = $ingresos - $egresos;

                $contenido = [
                    'ingresos' => $ingresos,
                    'egresos' => $egresos,
                    'ganancia' => $ganancia,
                    'detalle' => $transacciones->map(function ($transaccion) {
                        return [
                            'fecha_transaccion' => $transaccion->fecha_transaccion,
                            'tipo_transaccion' => $transaccion->tipo_transaccion,
                            'monto' => $transaccion->monto,
                            'descripcion' => $transaccion->descripcion ?? 'Sin descripción',
                        ];
                    }),
                ];
                $descripcion = "Reporte de ingresos y egresos del {$request->fecha_inicio} al {$request->fecha_fin}";
                break;

            case 'ServiciosMasSolicitados':
                $servicios = Factura::where('id_centro', Auth::user()->id_centro)
                    ->whereBetween('fecha_factura', [$request->fecha_inicio, $request->fecha_fin])
                    ->with('servicios.servicio') // Carga los servicios relacionados
                    ->get()
                    ->pluck('servicios')
                    ->flatten()
                    ->groupBy('id_servicio')
                    ->map(function ($group) {
                        return [
                            'servicio' => $group->first()?->servicio?->nombre_servicio ?? 'Servicio no registrado',
                            'cantidad' => $group->count(),
                        ];
                    })
                    ->sortByDesc('cantidad')
                    ->values();

                $contenido = [
                    'detalle' => $servicios,
                ];
                $descripcion = "Servicios más solicitados del {$request->fecha_inicio} al {$request->fecha_fin}";
                break;

            case 'PacientesAtendidos':
                $facturas = Factura::where('id_centro', Auth::user()->id_centro)
                    ->whereBetween('fecha_factura', [$request->fecha_inicio, $request->fecha_fin])
                    ->with('paciente', 'servicios.servicio') // Carga relaciones de pacientes y servicios
                    ->get();

                $detallePacientes = $facturas->groupBy('paciente.id_paciente')->map(function ($facturasPorPaciente) {
                    $paciente = $facturasPorPaciente->first()->paciente;
                    return [
                        'paciente' => [
                            'nombre' => $paciente ? "{$paciente->primer_nombre} {$paciente->primer_apellido}" : 'Sin Nombre',
                            'dni' => $paciente->dni ?? 'Sin DNI',
                            'genero' => $paciente->genero ?? 'Sin género',
                        ],
                        'servicios' => $facturasPorPaciente->pluck('servicios')->flatten()->groupBy('id_servicio')->map(function ($group) {
                            return [
                                'nombre_servicio' => $group->first()->servicio->nombre_servicio ?? 'Servicio no registrado',
                                'cantidad' => $group->count(),
                            ];
                        })->values(),
                    ];
                })->values();

                $contenido = [
                    'detalle' => $detallePacientes,
                ];
                $descripcion = "Pacientes atendidos del {$request->fecha_inicio} al {$request->fecha_fin}";
                break;


            default:
                return redirect()->route('reportes.index')->withErrors(['error' => 'Tipo de reporte no válido.']);
        }

        $reporte = Reporte::create([
            'id_centro' => Auth::user()->id_centro,
            'tipo_reporte' => $tipo,
            'descripcion' => $descripcion,
            'fecha_reporte' => now(),
            'contenido' => json_encode($contenido),
        ]);

        return redirect()->route('reportes.show', $reporte->id_reporte)->with('success', 'Reporte generado correctamente.');
    }

    public function show($id)
    {
        $reporte = Reporte::where('id_centro', Auth::user()->id_centro)->findOrFail($id);

        $contenido = json_decode($reporte->contenido, true);

        return view('admin.centro.reportes.show', compact('reporte', 'contenido'));
    }

    public function exportarPDF($id)
    {
        $reporte = Reporte::where('id_centro', Auth::user()->id_centro)->findOrFail($id);

        $contenido = json_decode($reporte->contenido, true);

        $pdf = Pdf::loadView('admin.centro.reportes.pdf', compact('reporte', 'contenido'));

        return $pdf->download("Reporte-{$reporte->tipo_reporte}.pdf");
    }
}
