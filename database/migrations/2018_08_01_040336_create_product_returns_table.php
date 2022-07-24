<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductReturnsTable extends Migration
{

    public function up()
    {
        Schema::create('product_returns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('return_id');
            $table->integer('product_id');
            $table->double('qty');
            $table->double('product_price');
            $table->double('total');
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
        Schema::dropIfExists('product_returns');
    }
}
