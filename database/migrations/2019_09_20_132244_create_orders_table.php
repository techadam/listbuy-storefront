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
            $table->string('generated_id')->unique();
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('payment_record_id');
            $table->unsignedBigInteger('logistic_record_id')->nullable();
            $table->text('shipping_address');
            $table->enum('status', ['pending','completed'])->default("pending");
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
