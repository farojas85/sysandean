<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlmacenadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('almacenados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lote_id')->nullable()->constrained('lotes');
            $table->unsignedInteger('cajas');
            $table->decimal('peso_caja',18,2);
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
        Schema::dropIfExists('almacenados');
    }
}
