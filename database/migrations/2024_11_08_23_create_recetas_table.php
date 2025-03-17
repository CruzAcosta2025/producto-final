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
        Schema::create('recetas', function (Blueprint $table) {
            $table->bigIncrements('id_receta');
            $table->unsignedBigInteger('id_historial');
            $table->unsignedBigInteger('id_medico');
            $table->timestamp('fecha_receta')->useCurrent();
            $table->timestamps();

            $table->foreign('id_historial')->references('id_historial')->on('historial_clinico');
            $table->foreign('id_medico')->references('id_personal_medico')->on('personal_medico');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recetas');
    }
};
