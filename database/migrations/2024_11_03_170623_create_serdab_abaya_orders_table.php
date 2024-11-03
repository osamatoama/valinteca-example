<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerdabAbayaOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serdab_abaya_orders', function (Blueprint $table) {
            $table->id();
            $table->string('salla_order_id', 400);
            $table->string('order_number', 400);
            $table->string('order_status', 400);
            $table->timestamp('order_date');
            $table->boolean('is_synced')->default(false);
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
        Schema::dropIfExists('serdab_abaya_orders');
    }
}
