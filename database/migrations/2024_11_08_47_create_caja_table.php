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
        Schema::create('caja', function (Blueprint $table) {
            $table->bigIncrements('id_transaccion');
            $table->unsignedBigInteger('id_centro');
            $table->unsignedBigInteger('id_factura')->nullable();
            $table->date('fecha_transaccion');
            $table->decimal('monto', 10, 2);
            $table->enum('tipo_transaccion', ['INGRESO', 'GASTO']);
            $table->text('descripcion')->nullable();
            $table->timestamps();

            $table->foreign('id_centro')->references('id_centro')->on('centros_medicos');
            $table->foreign('id_factura')->references('id_factura')->on('facturas');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caja');
    }
};
