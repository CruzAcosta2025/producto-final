<?php

namespace App\Http\Controllers\CentroMedico\Historial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArchivoAdjunto;
use App\Models\HistorialClinico;
use App\Models\Consulta;
use App\Models\ExamenMedico;
use Illuminate\Support\Facades\Storage;

class ArchivosAdjuntosController extends Controller
{
    public function index(Request $request, $idHistorial = null)
    {
        $dni = $request->get('dni');
        $paciente = null;
        $archivos = collect();
        $consultas = collect();
        $examenes = collect();

        if ($idHistorial) {
            $archivos = ArchivoAdjunto::where('id_historial', $idHistorial)->get();
        } elseif ($dni) {
            $paciente = HistorialClinico::whereHas('paciente', function ($query) use ($dni) {
                $query->where('dni', $dni);
            })->with(['paciente', 'consultas', 'examenesMedicos'])->first();

            if ($paciente) {
                $consultas = $paciente->consultas;
                $examenes = $paciente->examenesMedicos;
            }
        }

        return view('admin.centro.historial.archivos.index', compact('archivos', 'dni', 'paciente', 'consultas', 'examenes', 'idHistorial'));
    }


    public function create($idHistorial, Request $request)
    {
        $historial = HistorialClinico::findOrFail($idHistorial);
        $consultas = Consulta::where('id_historial', $idHistorial)->get();
        $examenes = ExamenMedico::where('id_historial', $idHistorial)->get();

        return view('admin.centro.historial.archivos.create', compact('historial', 'consultas', 'examenes'));
    }

    public function store(Request $request, $idHistorial)
    {
        $request->validate([
            'tipo_archivo' => 'required|string',
            'archivo' => 'required|file',
            'descripcion' => 'nullable|string',
            'id_consulta' => 'nullable|exists:consultas,id_consulta',
            'id_examen' => 'nullable|exists:examenes_medicos,id_examen',
        ]);

        // Guardar el archivo en storage/app/public/archivos
        $filePath = $request->file('archivo')->store('archivos', 'public');

        // Copiar el archivo a public/storage/archivos
        $publicPath = public_path('storage/archivos');
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0755, true); // Crear la carpeta si no existe
        }
        copy(storage_path('app/public/' . $filePath), $publicPath . '/' . basename($filePath));

        // Registrar en la base de datos
        ArchivoAdjunto::create([
            'id_historial' => $idHistorial,
            'id_consulta' => $request->id_consulta,
            'id_examen' => $request->id_examen,
            'tipo_archivo' => $request->tipo_archivo,
            'nombre_archivo' => $request->file('archivo')->getClientOriginalName(),
            'ruta_archivo' => $filePath,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('archivos.index', $idHistorial)
            ->with('success', 'Archivo subido exitosamente.');
    }


    public function destroy($idHistorial, $idArchivo)
    {
        $archivo = ArchivoAdjunto::findOrFail($idArchivo);

        Storage::disk('public')->delete($archivo->ruta_archivo);
        $archivo->delete();

        return redirect()->route('archivos.index', $idHistorial)
            ->with('success', 'Archivo eliminado exitosamente.');
    }
}
