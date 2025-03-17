<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = true;

    protected $fillable = [
        'id_centro',
        'nombre',
        'email',
        'password',
        'id_rol',
        'estado'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function centroMedico()
    {
        return $this->belongsTo(CentroMedico::class, 'id_centro');
    }

    public function personalMedico()
    {
        return $this->hasMany(PersonalMedico::class, 'id_usuario', 'id_usuario');
    }

    public function consultas()
    {
        return $this->hasManyThrough(Consulta::class, PersonalMedico::class, 'id_usuario', 'id_medico', 'id_usuario', 'id_personal_medico');
    }


    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }
}
