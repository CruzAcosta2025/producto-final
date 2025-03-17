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
        Schema::create('solicitudes_sangre', function (Blueprint $table) {
            $table->bigIncrements('id_solicitud');
            $table->unsignedBigInteger('id_paciente');
            $table->string('tipo_sangre', 5);
            $table->integer('cantidad');
            $table->enum('urgencia', ['BAJA', 'MEDIA', 'ALTA']);
            $table->enum('estado', ['PENDIENTE', 'COMPLETADA', 'CANCELADA'])->default('PENDIENTE');
            $table->date('fecha_solicitud');
            $table->date('fecha_completada')->nullable();
            $table->timestamps();

            $table->foreign('id_paciente')->references('id_paciente')->on('pacientes');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_sangre');
    }
};
