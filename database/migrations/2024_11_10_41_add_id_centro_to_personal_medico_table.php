<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('personal_medico', function (Blueprint $table) {
            $table->unsignedBigInteger('id_centro')->after('id_personal_medico'); // Coloca la columna después del 'id' (puedes cambiar esto según tu estructura).
            $table->foreign('id_centro')->references('id_centro')->on('centros_medicos')->onDelete('cascade'); // Clave foránea.
        });
    }


    public function down()
    {
        Schema::table('personal_medico', function (Blueprint $table) {
            $table->dropForeign(['id_centro']);
            $table->dropColumn('id_centro');
        });
    }
};
