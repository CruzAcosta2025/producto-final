<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Especialidad;

class EspecialidadSeeder extends Seeder
{
    public function run()
    {
        $especialidades = [
            ['nombre_especialidad' => 'Cardiología', 'descripcion' => 'Especialidad de enfermedades del corazón'],
            ['nombre_especialidad' => 'Pediatría', 'descripcion' => 'Especialidad de atención médica infantil'],
            ['nombre_especialidad' => 'Neurología', 'descripcion' => 'Especialidad en el sistema nervioso'],
            // Agrega más especialidades según sea necesario
        ];

        foreach ($especialidades as $especialidad) {
            Especialidad::create($especialidad);
        }
    }
}
