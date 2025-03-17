<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cie10 extends Model
{
    use HasFactory;

    protected $table = 'cie_10'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id_cie10'; // Clave primaria

    protected $fillable = [
        'grupo',
        'categoria',
        'subcategoria',
    ];

    public function diagnosticos()
    {
        return $this->hasMany(Diagnostico::class, 'id_cie10', 'id_cie10');
    }
}
