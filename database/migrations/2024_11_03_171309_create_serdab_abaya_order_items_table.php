<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerdabAbayaOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serdab_abaya_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('salla_order_number');
            $table->string('sku', 400)->nullable();
            $table->string('status', 400);
            $table->string('quantity', 400);
            $table->string('size', 400)->nullable();
            $table->longText('notes')->nullable();

            $table->string('order_date', 400);
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
        Schema::dropIfExists('serdab_abaya_order_items');
    }
}
