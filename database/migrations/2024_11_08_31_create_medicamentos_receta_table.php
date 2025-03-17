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
        Schema::create('medicamentos_receta', function (Blueprint $table) {
            $table->bigIncrements('id_medicamento_receta');
            $table->unsignedBigInteger('id_receta');
            $table->string('medicamento', 100);
            $table->string('dosis', 50);
            $table->string('frecuencia', 50);
            $table->string('duracion', 50);
            $table->text('instrucciones')->nullable();
            $table->timestamps();

            $table->foreign('id_receta')->references('id_receta')->on('recetas');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicamentos_receta');
    }
};
