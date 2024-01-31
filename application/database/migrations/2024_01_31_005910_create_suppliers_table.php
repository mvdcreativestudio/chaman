<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('razon_social');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('celular');
            $table->string('email');
            $table->string('ciudad');
            $table->string('departamento');
            $table->string('pais');
            $table->string('rucFranquicia');
            $table->string('accion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}
