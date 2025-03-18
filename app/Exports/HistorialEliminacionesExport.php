<?php

namespace App\Exports;

use App\Models\HistorialEliminaciones;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistorialEliminacionesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return HistorialEliminaciones::with(['usuario', 'centroMedico'])->get()->map(function ($eliminacion) {
            return [
                'Usuario' => $eliminacion->usuario ? $eliminacion->usuario->nombre : 'N/A',
                'Centro Médico' => $eliminacion->centroMedico ? $eliminacion->centroMedico->nombre : 'N/A',
                'Tipo de Recurso' => $eliminacion->recurso_tipo,
                'Recurso Eliminado' => $eliminacion->recurso_nombre,
                'Detalles' => $eliminacion->detalles,
                'Fecha' => $eliminacion->fecha_eliminacion ? $eliminacion->fecha_eliminacion->format('d/m/Y H:i') : 'Sin fecha',
            ];
        });
    }

    public function headings(): array
    {
        return ['Usuario', 'Centro Médico', 'Tipo de Recurso', 'Recurso Eliminado', 'Detalles', 'Fecha'];
    }
}
