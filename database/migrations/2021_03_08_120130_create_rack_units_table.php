<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRackUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rack_units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rack_id');
            $table->unsignedTinyInteger('unit_no');
            $table->unsignedBigInteger('hardware_id');
            $table->unsignedTinyInteger('position');
//            $table->boolean('front');
//            $table->boolean('interior');
//            $table->boolean('back');
            $table->timestamps();

            $table->foreign('rack_id')->references('id')->on('racks');
            $table->foreign('hardware_id')->references('id')->on('hardware');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rack_units');
    }
}
