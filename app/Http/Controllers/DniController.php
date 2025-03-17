<?php

namespace App\Http\Controllers;

use App\Services\ReniecService;
use Illuminate\Http\Request;

class DniController extends Controller
{
    protected $reniecService;

    public function __construct(ReniecService $reniecService)
    {
        $this->reniecService = $reniecService;
    }

    public function buscarDni($dni)
    {
        // Validar que sea un DNI de 8 dígitos
        if (!preg_match('/^\d{8}$/', $dni)) {
            return response()->json(['error' => 'DNI no válido'], 400);
        }

        // Consultar el DNI en la API
        $datos = $this->reniecService->consultarDni($dni);

        // Si la API no encontró el DNI, devolver error
        if (isset($datos['error'])) {
            return response()->json(['error' => 'DNI no encontrado'], 404);
        }

        // Retornar los datos en JSON
        return response()->json([
            'dni' => $datos['numero'] ?? '',
            'primer_nombre' => $datos['nombres'] ?? '',
            'primer_apellido' => $datos['apellido_paterno'] ?? '',
            'segundo_apellido' => $datos['apellido_materno'] ?? '',
        ]);
    }
}
