<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonadorSangre extends Model
{
    use HasFactory;

    protected $table = 'donadores_sangre';
    protected $primaryKey = 'id_donador';
    public $timestamps = true;

    protected $fillable = [
        'id_centro',
        'id_paciente',
        'nombre',
        'apellido',
        'dni',
        'tipo_sangre',
        'estado',
        'telefono',
        'ultima_donacion'
    ];

    public function centroMedico()
    {
        return $this->belongsTo(CentroMedico::class, 'id_centro');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }
}
