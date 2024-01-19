<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFranchiseIdToPhoneNumbers extends Migration
{
    public function up()
    {
        Schema::table('phone_numbers', function (Blueprint $table) {
            $table->unsignedBigInteger('franchise_id')->nullable()->after('is_franchise');
            $table->foreign('franchise_id')->references('id')->on('franchises');
        });
    }

    public function down()
    {
        Schema::table('phone_numbers', function (Blueprint $table) {
            $table->dropForeign(['franchise_id']);
            $table->dropColumn('franchise_id');
        });
    }
}
