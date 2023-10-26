<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModuleTargetToObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('objectives', function (Blueprint $table) {
            $table->enum('module_target', ['leads_created', 'leads_converted', 'sales_created', 'sales_converted', 'reduce_expenses', 'total_clients', 'new_clients', 'GMV', 'CAC', 'total_orders', 'ticket_medio', 'ARPU', 'category_sales', 'family_sales'])->nullable()->after('module');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('objectives', function (Blueprint $table) {
            $table->dropColumn('module_target');
        });
    }
}
