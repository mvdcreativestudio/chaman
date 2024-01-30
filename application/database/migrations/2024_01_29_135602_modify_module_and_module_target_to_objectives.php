<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyModuleAndModuleTargetToObjectives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('objectives', function (Blueprint $table) {

            $newValues = "'leads', 'sales', 'payments', 'clients', 'expenses', 'incomes'"; 

            // Cambiar la columna 'module'
            DB::statement("ALTER TABLE objectives MODIFY COLUMN module ENUM($newValues)");
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
            // Lista de valores ENUM original
            $originalValues = "'leads', 'sales', 'payments', 'clients', 'expenses'"; 

            // Revertir el cambio en la columna 'module'
            DB::statement("ALTER TABLE objectives MODIFY COLUMN module ENUM($originalValues)");
        });
    }
}
