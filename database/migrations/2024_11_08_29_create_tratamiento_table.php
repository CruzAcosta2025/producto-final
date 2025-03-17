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
        Schema::create('tratamiento', function (Blueprint $table) {
            $table->bigIncrements('id_tratamiento');
            $table->unsignedBigInteger('id_historial');
            $table->text('descripcion');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamps();

            $table->foreign('id_historial')->references('id_historial')->on('historial_clinico');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tratamiento');
    }
};
