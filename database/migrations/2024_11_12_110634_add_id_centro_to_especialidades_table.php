<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('especialidades', function (Blueprint $table) {
            $table->unsignedBigInteger('id_centro')->after('id_especialidad');
            $table->foreign('id_centro')->references('id_centro')->on('centros_medicos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('especialidades', function (Blueprint $table) {
            $table->dropForeign(['id_centro']);
            $table->dropColumn('id_centro');
        });
    }
};
