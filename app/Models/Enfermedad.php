<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enfermedad extends Model
{
    use HasFactory;

    protected $table = 'enfermedades';
    protected $primaryKey = 'id_enfermedad';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'descripcion'
    ];
}
