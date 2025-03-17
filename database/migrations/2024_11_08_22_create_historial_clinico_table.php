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
        Schema::create('historial_clinico', function (Blueprint $table) {
            $table->bigIncrements('id_historial');
            $table->unsignedBigInteger('id_paciente');
            $table->unsignedBigInteger('id_centro');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamps();

            $table->foreign('id_paciente')->references('id_paciente')->on('pacientes');
            $table->foreign('id_centro')->references('id_centro')->on('centros_medicos');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_clinico');
    }
};
