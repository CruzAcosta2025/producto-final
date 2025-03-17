<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('personal_medico', function (Blueprint $table) {
            $table->unsignedBigInteger('id_especialidad')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('personal_medico', function (Blueprint $table) {
            $table->unsignedBigInteger('id_especialidad')->nullable(false)->change();
        });
    }
};
