<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialEliminaciones extends Model
{
    use HasFactory;

    protected $table = 'historial_eliminaciones';
    protected $primaryKey = 'id_historial';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_centro',
        'recurso_tipo',
        'recurso_nombre',
        'detalles',
        'fecha_eliminacion'
    ];
    protected $casts = [
        'fecha_eliminacion' => 'datetime',
    ];


    // Relación con el usuario que realizó la eliminación
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function centroMedico()
    {
        return $this->belongsTo(CentroMedico::class, 'id_centro', 'id_centro');
    }
}
