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
        Schema::create('personal_medico', function (Blueprint $table) {
            $table->bigIncrements('id_personal_medico');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_especialidad');
            $table->string('dni', 20)->unique();
            $table->string('telefono', 20);
            $table->string('correo_contacto', 100);
            $table->decimal('sueldo', 10, 2);
            $table->string('codigo_postal', 10);
            $table->date('fecha_alta');
            $table->date('fecha_baja')->nullable();
            $table->string('banco', 100);
            $table->string('numero_cuenta', 50);
            $table->string('numero_colegiatura', 50);
            $table->text('direccion');
            $table->timestamps();

            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
            $table->foreign('id_especialidad')->references('id_especialidad')->on('especialidades');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_medico');
    }
};
