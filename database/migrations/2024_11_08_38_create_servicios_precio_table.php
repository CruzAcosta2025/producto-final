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
        Schema::create('servicios_precio', function (Blueprint $table) {
            $table->bigIncrements('id_servicio');
            $table->unsignedBigInteger('id_centro');
            $table->string('nombre_servicio', 191);
            $table->enum('categoria_servicio', ['DIAGNOSTICO', 'CONSULTA', 'EXAMEN']);
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->enum('estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamps();

            $table->foreign('id_centro')->references('id_centro')->on('centros_medicos');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios_precio');
    }
};
