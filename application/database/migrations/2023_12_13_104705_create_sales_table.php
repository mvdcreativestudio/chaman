<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->json('lineas');
            $table->json('impuestos');
            $table->decimal('subtotal');
            $table->decimal('total');
            $table->string('moneda');
            $table->integer('moneda_id');
            $table->enum('estado', ['Pagado', 'No Pagado', 'Pago parcial', 'Anulado']);
            $table->date('fecha_creacion');
            $table->date('fecha_emision');
            $table->json('pagos');
            $table->string('ruc_franquicia');
            $table->string('accion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
