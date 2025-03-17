<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;

    protected $table = 'recetas';
    protected $primaryKey = 'id_receta';
    public $timestamps = true;

    protected $fillable = [
        'id_historial',
        'id_medico',
        'fecha_receta'
    ];

    public function historialClinico()
    {
        return $this->belongsTo(HistorialClinico::class, 'id_historial');
    }

    public function personalMedico()
    {
        return $this->belongsTo(PersonalMedico::class, 'id_medico');
    }
    public function medicamentos()
    {
        return $this->hasMany(MedicamentoReceta::class, 'id_receta');
    }
}
