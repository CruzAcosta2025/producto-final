<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturaServiciosTable extends Migration
{
    public function up()
    {
        Schema::create('factura_servicios', function (Blueprint $table) {
            $table->id('id_factura_servicio');
            $table->unsignedBigInteger('id_factura');
            $table->unsignedBigInteger('id_servicio');
            $table->integer('cantidad')->default(1);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();

            // Relación con facturas
            $table->foreign('id_factura')->references('id_factura')->on('facturas')->onDelete('cascade');

            // Relación con servicios_precio
            $table->foreign('id_servicio')->references('id_servicio')->on('servicios_precio')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('factura_servicios');
    }
}
