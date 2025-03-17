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
        Schema::create('donadores_sangre', function (Blueprint $table) {
            $table->bigIncrements('id_donador');
            $table->unsignedBigInteger('id_paciente')->nullable();
            $table->string('nombre', 191);
            $table->string('apellido', 191);
            $table->string('tipo_sangre', 5)->nullable();
            $table->enum('estado', ['POR_EXAMINAR', 'APTO', 'NO_APTO'])->default('POR_EXAMINAR');
            $table->date('ultima_donacion')->nullable();
            $table->timestamps();

            $table->foreign('id_paciente')->references('id_paciente')->on('pacientes');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donadores_sangre');
    }
};
