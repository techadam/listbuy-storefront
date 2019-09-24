<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('buyer_id');
            $table->integer('payment_record_id')->nullable();
            $table->string('generated_order_id');
            $table->string('price');
            $table->string('payment_vendor')->nullable();
            $table->string('logistic_vendor')->nullable();
            $table->integer('logistic_record_id')->nullable();

            $table->string('description')->nullable();
            $table->string('order_status')->default("pending")->nullable();

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
        Schema::dropIfExists('orders');
    }
}
