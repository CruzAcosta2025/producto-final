<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ReniecService
{
    private $token = "a9e582132e9a062dfc61ccbede0774914e0ea59bc8a2132401f52106f323d773"; // Reemplaza con tu token correcto

    public function consultarDni($dni)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->post('https://apiperu.dev/api/dni', ['dni' => $dni]);

        // Verificar si la API responde correctamente
        if ($response->failed()) {
            return ['error' => 'Error en la API'];
        }

        // Obtener JSON de respuesta
        $data = $response->json();

        // Verificar si el DNI fue encontrado
        if (!isset($data['data']['numero'])) {
            return ['error' => 'DNI no encontrado'];
        }

        return $data['data'];
    }
}
