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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->bigIncrements('id_paciente');
            $table->unsignedBigInteger('id_centro');
            $table->string('primer_nombre', 50);
            $table->string('segundo_nombre', 50)->nullable();
            $table->string('primer_apellido', 50);
            $table->string('segundo_apellido', 50)->nullable();
            $table->date('fecha_nacimiento');
            $table->enum('genero', ['MASCULINO', 'FEMENINO']);
            $table->string('dni', 20)->unique();
            $table->text('direccion');
            $table->string('telefono', 20);
            $table->string('email', 100);
            $table->string('grupo_sanguineo', 5);
            $table->string('nombre_contacto_emergencia', 191);
            $table->string('telefono_contacto_emergencia', 20);
            $table->enum('relacion_contacto_emergencia', ['FAMILIAR', 'AMIGO', 'PAREJA', 'PADRE', 'MADRE', 'HERMANO', 'HERMANA', 'OTRO']);
            $table->enum('es_donador', ['SI', 'NO', 'POR_EXAMINAR'])->default('NO');
            $table->timestamps();

            $table->foreign('id_centro')->references('id_centro')->on('centros_medicos');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
