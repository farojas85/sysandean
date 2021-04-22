<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\RenameColumn;
use Illuminate\Support\Facades\Schema;

class RenameColumnToRectificadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rectificados', function (Blueprint $table) {
            $table->renameColumn('kilogrado_rectificado','kilogramo_rectificado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rectificados', function (Blueprint $table) {
            $table->renameColumn('kilogramo_rectificado','kilogrado_rectificado');
        });
    }
}
