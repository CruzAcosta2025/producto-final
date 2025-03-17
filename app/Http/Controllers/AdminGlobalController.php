<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CentroMedico;
use App\Models\Usuario;
use App\Models\Paciente;
use App\Models\PersonalMedico;
use App\Models\Factura;
use App\Models\Consulta;
use App\Models\Cirugia;
use App\Models\Caja;
use Carbon\Carbon;

class AdminGlobalController extends Controller
{
    public function dashboard()
    {

    // Obtener todos los centros médicos
    $centros = CentroMedico::all();

    // Obtener nombres de los centros médicos
    $nombresCentros = $centros->pluck('nombre'); 

    // Obtener la cantidad de pacientes por centro
    $cantidadPacientes = $centros->map(function ($centro) {
        return $centro->pacientes()->count();
    });

    // Obtener el total de centros médicos
    $totalCentrosMedicos = $centros->count();

    // Obtener el total de pacientes registrados
    $totalPacientes = Paciente::count();

    // Obtener el total de personal médico
    $totalPersonalMedico = PersonalMedico::count();

    // Cantidad de consultas médicas realizadas
    $totalConsultas = Consulta::count();

    // Cantidad de cirugías realizadas
    $totalCirugias = Cirugia::count();

    // Pasar datos a la vista
    return view('admin.global.dashboard', compact(
        'totalCentrosMedicos',
        'totalPacientes',
        'totalPersonalMedico',
        'totalConsultas',
        'totalCirugias',
        'nombresCentros',
        'cantidadPacientes'
    ));
}

}

