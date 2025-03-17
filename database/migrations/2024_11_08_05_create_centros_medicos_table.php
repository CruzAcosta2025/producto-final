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
        Schema::create('centros_medicos', function (Blueprint $table) {
            $table->bigIncrements('id_centro');
            $table->string('nombre', 191);
            $table->string('direccion', 255);
            $table->string('logo', 191)->nullable();
            $table->string('ruc', 20)->unique();
            $table->string('color_tema', 7)->nullable();
            $table->enum('estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->timestamp('creado_en')->useCurrent();
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centros_medicos');
    }
};
