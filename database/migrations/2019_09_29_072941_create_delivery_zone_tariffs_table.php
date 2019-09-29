<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryZoneTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_zone_tariffs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sending_state_code');
            $table->string('receiving_state_code');
            $table->unsignedBigInteger('delivery_zone_id');
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
        Schema::dropIfExists('delivery_zone_tariffs');
    }
}
