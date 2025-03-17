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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('id_usuario');
            $table->unsignedBigInteger('id_centro')->nullable();
            $table->string('nombre', 50);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->unsignedBigInteger('id_rol');
            $table->enum('estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamps();

            $table->foreign('id_centro')->references('id_centro')->on('centros_medicos');
            $table->foreign('id_rol')->references('id_rol')->on('roles');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
