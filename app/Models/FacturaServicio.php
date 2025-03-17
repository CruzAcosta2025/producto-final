<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaServicio extends Model
{
    use HasFactory;

    protected $table = 'factura_servicios';
    protected $primaryKey = 'id_factura_servicio';
    public $timestamps = true;

    protected $fillable = [
        'id_factura',
        'id_servicio',
        'cantidad',
        'subtotal'
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'id_factura');
    }

    public function servicio()
    {
        return $this->belongsTo(ServicioPrecio::class, 'id_servicio');
    }
}
