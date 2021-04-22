<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCongeladosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('congelados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lote_id')->nullable()->constrained('lotes');
            $table->float('kilogramo_congelado');
            $table->string('observacion',255)->nullable();
            $table->date('fecha_registro');
            $table->foreignId('trabajador_id')->nullable()->constrained('trabajadores');
            $table->unsignedBigInteger('usuario_crea')->nullable();
            $table->unsignedBigInteger('usuario_modifica')->nullable();
            $table->unsignedBigInteger('usuario_elimina')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('congelados');
    }
}
