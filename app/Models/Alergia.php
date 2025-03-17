<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alergia extends Model
{
    use HasFactory;

    protected $table = 'alergias';
    protected $primaryKey = 'id_alergia';
    public $timestamps = true;

    protected $fillable = [
        'id_paciente',
        'tipo',
        'descripcion',
        'severidad'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }
}
