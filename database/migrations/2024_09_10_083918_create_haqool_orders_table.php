<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHaqoolOrdersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('haqool_orders', function (Blueprint $table) {
            $table->id();
            $table->longText('product_name');
            $table->string('sku', 400);
            $table->string('brand', 400);
            $table->string('cost', 400);
            $table->string('quantity', 400);
            $table->string('total', 400);
            $table->string('salla_order_id', 400);
            $table->string('invoice_number', 400)->nullable();
            $table->string('order_number', 400);
            $table->dateTime('order_date');
            $table->string('order_status', 400);
            $table->string('client_name', 400);
            $table->string('client_email', 400);
            $table->string('client_phone', 400);
            $table->string('client_city', 400);
            $table->string('payment_method', 400);
            $table->json('payload');
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
        Schema::dropIfExists('haqool_orders');
    }
}
