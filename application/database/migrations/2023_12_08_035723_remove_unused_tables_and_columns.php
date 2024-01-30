<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUnusedTablesAndColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Eliminar las tablas innecesarias
        Schema::dropIfExists('franchise_phone');
        Schema::dropIfExists('incoming_phone_numbers');

        // Eliminar las columnas polimorficas en la tabla messages
        Schema::table('messages', function (Blueprint $table) {
            $table->dropMorphs('from_phone');
            $table->dropMorphs('to_phone');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
