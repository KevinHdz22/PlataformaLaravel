<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('password_resets', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_usuario');
        $table->string('codigo_recuperacion')->nullable();
        $table->timestamp('fecha_expiracion_codigo')->nullable();
        $table->timestamps();
        $table->foreign('id_usuario')->references('id')->on('users'); 
    });
}



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
};
