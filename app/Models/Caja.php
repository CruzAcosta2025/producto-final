<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $table = 'caja';
    protected $primaryKey = 'id_transaccion';
    public $timestamps = true;

    protected $fillable = [
        'id_centro',
        'id_factura',
        'fecha_transaccion',
        'monto',
        'tipo_transaccion',
        'descripcion'
    ];

    public function centroMedico()
    {
        return $this->belongsTo(CentroMedico::class, 'id_centro');
    }

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'id_factura');
    }
}
