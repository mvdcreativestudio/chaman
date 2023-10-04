<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objectives', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('module', ['leads', 'invoices', 'payments', 'clients', 'expenses']);
            $table->unsignedInteger('target_value');
            $table->integer('user_id')->nullable();
            $table->unsignedBigInteger('franchise_id')->nullable();
            $table->timestamps();
    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('franchise_id')->references('id')->on('franchises')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objectives');
    }
}
