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
        Schema::create('cirugias', function (Blueprint $table) {
            $table->bigIncrements('id_cirugia');
            $table->unsignedBigInteger('id_historial');
            $table->string('tipo_cirugia', 100);
            $table->timestamp('fecha_cirugia');
            $table->string('cirujano', 100);
            $table->text('descripcion')->nullable();
            $table->text('complicaciones')->nullable();
            $table->text('notas_postoperatorias')->nullable();
            $table->timestamps();

            $table->foreign('id_historial')->references('id_historial')->on('historial_clinico');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cirugias');
    }
};
