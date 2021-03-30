<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeladoQuimicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelado_quimicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lote_id')->nullable()->constrained('lotes');
            $table->unsignedInteger('kilogramo');
            $table->date('fecha_registro');
            $table->string('observacion',255)->nullable();
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
        Schema::dropIfExists('pelado_quimicos');
    }
}
