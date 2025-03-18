<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Alergia extends Model
{
    use HasFactory, SoftDeletes; 

    protected $table = 'alergias';
    protected $primaryKey = 'id_alergia';
    public $timestamps = true;
    

    protected $dates = ['deleted_at']; 

    protected $fillable = [
        'id_paciente',
        'tipo',
        'descripcion',
        'severidad',
        'deleted_at' 
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }
}
