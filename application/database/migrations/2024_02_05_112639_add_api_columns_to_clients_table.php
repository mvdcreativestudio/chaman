<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApiColumnsToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('client_rut')->nullable()->after('client_id');
            $table->string('client_cedula')->nullable()->after('client_rut');
            $table->string('client_pasaporte')->nullable()->after('client_cedula');
            $table->string('client_documentoExt')->nullable()->after('client_pasaporte');
            $table->string('client_razon_social')->nullable()->after('client_documentoExt');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('client_rut');
            $table->dropColumn('client_cedula');
            $table->dropColumn('client_pasaporte');
            $table->dropColumn('client_documentoExt');
            $table->dropColumn('client_razon_social');
        });
    }
}
