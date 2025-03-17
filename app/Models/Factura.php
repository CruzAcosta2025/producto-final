<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'facturas';
    protected $primaryKey = 'id_factura';
    public $timestamps = true;

    protected $fillable = [
        'id_paciente',
        'id_centro',
        'id_personal_medico',
        'id_usuario', // Incluimos id_usuario como fillable
        'subtotal',
        'impuesto',
        'descuento',
        'total',
        'fecha_factura',
        'estado_pago',
        'metodo_pago'
    ];

    // Relación con Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }

    // Relación con Centro Médico
    public function centroMedico()
    {
        return $this->belongsTo(CentroMedico::class, 'id_centro');
    }

    // Relación con Personal Médico
    public function personalMedico()
    {
        return $this->belongsTo(PersonalMedico::class, 'id_personal_medico');
    }

    // Relación con Usuario (quién creó la factura)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    // Relación con FacturaServicio
    public function servicios()
    {
        return $this->hasMany(FacturaServicio::class, 'id_factura');
    }

    // Relación con Caja
    public function caja()
    {
        return $this->hasOne(Caja::class, 'id_factura');
    }

}
