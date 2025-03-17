<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioPrecio extends Model
{
    use HasFactory;

    protected $table = 'servicios_precio';
    protected $primaryKey = 'id_servicio';
    public $timestamps = true;

    protected $fillable = [
        'id_centro',
        'nombre_servicio',
        'categoria_servicio',
        'descripcion',
        'precio',
        'estado'
    ];

    public function centroMedico()
    {
        return $this->belongsTo(CentroMedico::class, 'id_centro');
    }

    public function facturas()
    {
        return $this->hasMany(FacturaServicio::class, 'id_servicio');
    }
}
