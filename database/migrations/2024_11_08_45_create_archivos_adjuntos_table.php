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
        Schema::create('archivos_adjuntos', function (Blueprint $table) {
            $table->bigIncrements('id_archivo');
            $table->unsignedBigInteger('id_historial')->nullable();
            $table->unsignedBigInteger('id_consulta')->nullable();
            $table->unsignedBigInteger('id_examen')->nullable();
            $table->string('tipo_archivo', 50);
            $table->string('nombre_archivo', 255);
            $table->string('ruta_archivo', 255);
            $table->timestamp('fecha_subida')->useCurrent();
            $table->text('descripcion')->nullable();
            $table->timestamps();

            $table->foreign('id_historial')->references('id_historial')->on('historial_clinico');
            $table->foreign('id_consulta')->references('id_consulta')->on('consultas');
            $table->foreign('id_examen')->references('id_examen')->on('examenes_medicos');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos_adjuntos');
    }
};
