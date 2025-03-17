<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    use HasFactory;

    protected $table = 'especialidades';
    protected $primaryKey = 'id_especialidad';
    public $timestamps = true;

    protected $fillable = [
        'nombre_especialidad',
        'descripcion',
        'id_centro'
    ];

    public function personalMedico()
    {
        return $this->hasMany(PersonalMedico::class, 'id_especialidad');
    }
}
