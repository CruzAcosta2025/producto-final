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
        Schema::create('vacunas', function (Blueprint $table) {
            $table->bigIncrements('id_vacuna');
            $table->unsignedBigInteger('id_historial');
            $table->string('nombre_vacuna', 100);
            $table->date('fecha_aplicacion');
            $table->string('dosis', 50)->nullable();
            $table->date('proxima_dosis')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('id_historial')->references('id_historial')->on('historial_clinico');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacunas');
    }
};
