<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyModuleTargetToObjectives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('objectives', function (Blueprint $table) {

            $newValues = "'leads_created', 'leads_converted', 'sales_created', 'sales_converted', 'reduce_expenses', 'total_clients', 'new_clients', 'GMV', 'CAC', 'total_orders', 'ticket_medio', 'ARPU', 'category_sales', 'family_sales', 'income_objective', 'increase_income'"; 

            // Cambiar la columna 'module'
            DB::statement("ALTER TABLE objectives MODIFY COLUMN module_target ENUM($newValues)");
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
            //
        });
    }
}
