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
        Schema::create('triaje', function (Blueprint $table) {
            $table->bigIncrements('id_triaje');
            $table->unsignedBigInteger('id_historial');
            $table->unsignedBigInteger('id_personal_medico');
            $table->string('presion_arterial', 20);
            $table->decimal('temperatura', 4, 2);
            $table->integer('frecuencia_cardiaca');
            $table->integer('frecuencia_respiratoria');
            $table->decimal('peso', 5, 2);
            $table->decimal('talla', 5, 2);
            $table->decimal('imc', 4, 2);
            $table->timestamp('fecha_triaje')->useCurrent();
            $table->timestamps();

            $table->foreign('id_historial')->references('id_historial')->on('historial_clinico');
            $table->foreign('id_personal_medico')->references('id_personal_medico')->on('personal_medico');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('triaje');
    }
};
