<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroMedico extends Model
{
    use HasFactory;

    protected $table = 'centros_medicos';
    protected $primaryKey = 'id_centro';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'direccion',
        'logo',
        'ruc',
        'color_tema',
        'estado',
    ];

    // Relaciones
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_centro');
    }

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'id_centro');
    }

    public function roles()
    {
        return $this->hasMany(Rol::class, 'id_centro');
    }

    public function permisos()
    {
        return $this->hasMany(Permiso::class, 'id_centro');
    }

}
