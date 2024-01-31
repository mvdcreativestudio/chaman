<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('codigo')->nullable();
            $table->string('nombre')->nullable();
            $table->integer('stock')->default(0)->nullable();
            $table->string('categoria')->nullable();
            $table->string('rucFranquicia')->nullable();
            $table->string('accion')->nullable();
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('codigo');
            $table->dropColumn('nombre');
            $table->dropColumn('stock');
            $table->dropColumn('categoria');
            $table->dropColumn('rucFranquicia');
            $table->dropColumn('accion');
        });
    }
    
}
