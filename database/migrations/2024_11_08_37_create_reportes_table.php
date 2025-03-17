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
        Schema::create('reportes', function (Blueprint $table) {
            $table->bigIncrements('id_reporte');
            $table->unsignedBigInteger('id_centro');
            $table->enum('tipo_reporte', ['INGRESOS_DIARIOS', 'INGRESOS_MENSUALES', 'GASTOS', 'PACIENTES', 'DONACIONES']);
            $table->text('descripcion')->nullable();
            $table->date('fecha_reporte');
            $table->json('contenido')->nullable();
            $table->timestamps();

            $table->foreign('id_centro')->references('id_centro')->on('centros_medicos');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
