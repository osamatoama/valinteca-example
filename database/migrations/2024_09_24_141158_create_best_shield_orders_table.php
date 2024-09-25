<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBestShieldOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('best_shield_orders', function (Blueprint $table) {
            $table->id();
            $table->string('salla_order_id', 400);
            $table->string('order_number', 400);
            $table->dateTime('order_date');
            $table->string('order_status', 400);
            $table->string('client_name', 400);
            $table->string('client_phone', 400);
            $table->string('client_city', 400);
            $table->string('client_country', 400);
            $table->string('shipping_country', 400);
            $table->string('shipping_city', 400);
            $table->string('payment_method', 400);
            $table->string('order_total', 400);
            $table->string('coupon', 400);
            $table->string('total_discount', 400);
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
        Schema::dropIfExists('best_shield_orders');
    }
}
