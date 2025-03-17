<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('roles_permisos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_centro')->nullable()->after('id_rol');

            // Añadir la relación con la tabla de centros médicos
            $table->foreign('id_centro')->references('id_centro')->on('centros_medicos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('roles_permisos', function (Blueprint $table) {
            $table->dropForeign(['id_centro']);
            $table->dropColumn('id_centro');
        });
    }
};
