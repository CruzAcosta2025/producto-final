<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pacientes', function (Blueprint $table) {
            // Cambiar 'relacion_contacto_emergencia' y 'es_donador' de ENUM a STRING
            $table->string('relacion_contacto_emergencia', 50)->change();
            $table->string('es_donador', 20)->default('NO')->change();
        });
    }

    public function down()
    {
        Schema::table('pacientes', function (Blueprint $table) {
            // Mantener los campos como STRING en la reversión, sin restricciones
            $table->string('relacion_contacto_emergencia', 50)->change();
            $table->string('es_donador', 20)->default('NO')->change();
        });
    }
};
