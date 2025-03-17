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
        Schema::create('alergias', function (Blueprint $table) {
            $table->bigIncrements('id_alergia');
            $table->unsignedBigInteger('id_paciente');
            $table->string('tipo', 50);
            $table->text('descripcion')->nullable();
            $table->string('severidad', 20);
            $table->timestamps();

            $table->foreign('id_paciente')->references('id_paciente')->on('pacientes');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alergias');
    }
};
