<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'id_rol';
    public $timestamps = true;

    protected $fillable = [
        'nombre_rol',
        'descripcion',
        'id_centro', // Asegúrate de incluir este campo
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_rol');
    }

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'roles_permisos', 'id_rol', 'id_permiso');
    }

    public function centroMedico()
    {
        return $this->belongsTo(CentroMedico::class, 'id_centro');
    }
}
