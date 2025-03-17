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
        Schema::create('historial_enfermedad', function (Blueprint $table) {
            $table->unsignedBigInteger('id_historial');
            $table->unsignedBigInteger('id_enfermedad');
            $table->date('fecha_diagnostico');
            $table->primary(['id_historial', 'id_enfermedad']);
            $table->timestamps();

            $table->foreign('id_historial')->references('id_historial')->on('historial_clinico');
            $table->foreign('id_enfermedad')->references('id_enfermedad')->on('enfermedades');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_enfermedad');
    }
};
