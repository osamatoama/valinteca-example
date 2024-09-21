<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHaqoolProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('haqool_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id', 400);
            $table->string('product_name', 400);
            $table->string('brand', 400);
            $table->string('cost', 400);
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
        Schema::dropIfExists('haqool_products');
    }
}
