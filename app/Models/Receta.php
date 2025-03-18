<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'recetas';
    protected $primaryKey = 'id_receta';
    public $timestamps = true;
    protected $dates = ['deleted_at'];

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
