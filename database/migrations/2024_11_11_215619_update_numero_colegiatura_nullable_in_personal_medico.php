<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('personal_medico', function (Blueprint $table) {
            $table->string('numero_colegiatura')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('personal_medico', function (Blueprint $table) {
            $table->string('numero_colegiatura')->nullable(false)->change();
        });
    }
};
