<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;

    protected $table = 'permisos';
    protected $primaryKey = 'id_permiso';
    public $timestamps = true;

    protected $fillable = [
        'nombre_modulo',
        'tipo_permiso',
        'id_centro',
    ];

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'roles_permisos', 'id_permiso', 'id_rol');
    }

    public function centroMedico()
    {
        return $this->belongsTo(CentroMedico::class, 'id_centro');
    }
}
