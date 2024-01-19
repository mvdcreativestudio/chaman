<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyEstadoOnSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::statement("ALTER TABLE sales MODIFY COLUMN estado ENUM('Pagado', 'No Pagado', 'Pago parcial', 'Anulada')");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE sales MODIFY COLUMN estado ENUM('Pagado', 'No Pagado', 'Pago parcial', 'Anulado')");

    }
}
