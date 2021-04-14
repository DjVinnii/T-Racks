<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hardware_id');
            $table->string('name');
            $table->string('mac_address')->nullable();
            $table->unsignedBigInteger('remote_port')->nullable();
            $table->timestamps();

            $table->foreign('hardware_id')->references('id')->on('hardware');
            $table->foreign('remote_port')->references('id')->on('ports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ports');
    }
}
