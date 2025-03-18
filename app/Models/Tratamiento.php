<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tratamiento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tratamiento';
    protected $primaryKey = 'id_tratamiento';
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id_historial',
        'descripcion',
        'fecha_creacion'
    ];

    public function historialClinico()
    {
        return $this->belongsTo(HistorialClinico::class, 'id_historial');
    }
}
