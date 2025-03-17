<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CentroMedico;

class CentrosMedicosSeeder extends Seeder
{
    public function run()
    {
        $centros = [
            [
                'nombre' => 'Centro Médico 1',
                'direccion' => 'Av. Salud 123, Lima',
                'logo' => 'logo1.png',
                'ruc' => '12345678901',
                'color_tema' => '#FF5733',
                'estado' => 'ACTIVO'
            ],
            [
                'nombre' => 'Centro Médico 2',
                'direccion' => 'Calle Bienestar 456, Arequipa',
                'logo' => 'logo2.png',
                'ruc' => '98765432109',
                'color_tema' => '#33FF57',
                'estado' => 'ACTIVO'
            ]
        ];

        foreach ($centros as $centro) {
            CentroMedico::create($centro);
        }
    }
}
