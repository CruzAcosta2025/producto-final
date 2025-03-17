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
        Schema::create('examenes_medicos', function (Blueprint $table) {
            $table->bigIncrements('id_examen');
            $table->unsignedBigInteger('id_historial');
            $table->string('tipo_examen', 100);
            $table->text('descripcion')->nullable();
            $table->date('fecha_examen');
            $table->text('resultados')->nullable();
            $table->timestamps();

            $table->foreign('id_historial')->references('id_historial')->on('historial_clinico');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examenes_medicos');
    }
};
