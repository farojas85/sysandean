<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('materia_prima_id')->nullable()->constrained('materia_primas');
            $table->unsignedInteger('kilogramo');
            $table->string('descripcion',255)->nullable();
            $table->date('fecha_registro');
            $table->unsignedInteger('maduros')->nullable();
            $table->unsignedInteger('pinton')->nullable();
            $table->unsignedInteger('verde')->nullable();
            $table->unsignedInteger('podrido')->nullable();
            $table->unsignedInteger('enanas')->nullable();
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
        Schema::dropIfExists('lotes');
    }
}
