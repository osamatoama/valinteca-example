<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSbaikSallaOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sbaik_salla_orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('email');
            $table->string('mobile');
            $table->string('sales_order_number');
            $table->string('sales_amount');
            $table->date('order_date');
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
        Schema::dropIfExists('sbaik_salla_orders');
    }
}
