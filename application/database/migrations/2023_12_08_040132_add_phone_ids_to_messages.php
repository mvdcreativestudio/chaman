<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneIdsToMessages extends Migration
{
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('from_phone_id');
            $table->unsignedBigInteger('to_phone_id');

            $table->foreign('from_phone_id')->references('id')->on('phone_numbers');
            $table->foreign('to_phone_id')->references('id')->on('phone_numbers');
        });
    }

    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['from_phone_id']);
            $table->dropColumn('from_phone_id');
            $table->dropForeign(['to_phone_id']);
            $table->dropColumn('to_phone_id');
        });
    }
}
