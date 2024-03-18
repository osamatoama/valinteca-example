<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZadlyOrdersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zadly_orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id', 300);
            $table->string('phone', 300);
            $table->string('purchase_date', 300);
            $table->string('purchase_product', 300);
            $table->string('quantity')->nullable();
            $table->string('amount');

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
        Schema::dropIfExists('zadly_orders');
    }
}
