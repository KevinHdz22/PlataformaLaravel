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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('primer_nombre');
            $table->string('primer_apellido');
            $table->string('correo')->unique();
            $table->string('contrasenia');
            $table->timestamps(); // Agrega automáticamente las columnas 'created_at' y 'updated_at'
            $table->unsignedBigInteger('usuario_modificacion')->nullable();
            $table->unsignedBigInteger('usuario_creacion')->nullable();
            $table->boolean('eliminado')->default(false);
        });
    }   

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
