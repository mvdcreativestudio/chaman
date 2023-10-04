<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFranchiseColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_franchised')->default(false);
            $table->unsignedBigInteger('franchise_id')->nullable();
            $table->foreign('franchise_id')->references('id')->on('franchises')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['franchise_id']);
            $table->dropColumn(['franchise_id', 'is_franchised']);
        });
    }
    
}
