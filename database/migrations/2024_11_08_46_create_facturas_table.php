<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->bigIncrements('id_factura');
            $table->unsignedBigInteger('id_paciente');
            $table->unsignedBigInteger('id_centro');
            $table->unsignedBigInteger('id_personal_caja');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('impuesto', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->date('fecha_factura');
            $table->enum('estado_pago', ['PENDIENTE', 'PAGADA'])->default('PENDIENTE');
            $table->enum('metodo_pago', ['EFECTIVO', 'TARJETA']);
            $table->timestamps();

            $table->foreign('id_paciente')->references('id_paciente')->on('pacientes');
            $table->foreign('id_centro')->references('id_centro')->on('centros_medicos');
            $table->foreign('id_personal_caja')->references('id_usuario')->on('usuarios');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
