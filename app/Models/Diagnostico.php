<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cie10;



class Diagnostico extends Model
{
    use HasFactory;

    protected $table = 'diagnostico';
    protected $primaryKey = 'id_diagnostico';
    public $timestamps = true;

    protected $fillable = [
        'id_historial',
        'descripcion',
        'fecha_creacion',
        'id_cie10',

    ];

    public function historialClinico()
    {
        return $this->belongsTo(HistorialClinico::class, 'id_historial');
    }

    public function cie10()
    {
        return $this->belongsTo(Cie10::class, 'id_cie10', 'id_cie10');
    }
}
