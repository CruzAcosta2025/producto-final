<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistorialEliminaciones;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use App\Exports\HistorialEliminacionesExport;
use Maatwebsite\Excel\Facades\Excel;


class HistorialEliminacionesController extends Controller
{
    // Muestra el historial de eliminaciones en la vista del Administrador Global
    public function index()
    {

        $eliminaciones = HistorialEliminaciones::with(['usuario', 'centroMedico'])->orderBy('fecha_eliminacion', 'desc')->paginate(10);

        return view('admin.global.historial.eliminaciones', compact('eliminaciones'));
        dd($eliminaciones->toArray());
    }


    // Función para registrar una eliminación en el historial
    public static function registrarEliminacion($recurso_tipo, $recurso_nombre, $recurso_detalles=null)
    {
        $usuario = Auth::user();

        HistorialEliminaciones::create([
            'id_usuario' => $usuario->id_usuario,
            'id_centro' => $usuario->id_centro,
            'recurso_tipo' => $recurso_tipo,
            'recurso_nombre' => $recurso_nombre,
            'detalles' => $recurso_detalles,
            'fecha_eliminacion' => now(),
        ]);
    }

    public function exportExcel()
    {
        return Excel::download(new HistorialEliminacionesExport, 'historial_eliminaciones.xlsx');
    }

}
