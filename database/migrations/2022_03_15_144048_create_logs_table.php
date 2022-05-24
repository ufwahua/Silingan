<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_login_id');
            $table->foreignId('user_logout_id')->nullable();
            $table->foreignId('card_id');
            $table->foreignId('block_lot_id');
            $table->enum('log_type',['visitor','vehicle']);
            $table->enum('vehicle_label',['motorcycle','car','truck','van','tricycle'])->nullable();
            $table->enum('vehicle_type',['public','private'])->nullable();
            $table->string('purpose_visit');
            $table->string('name')->nullable();
            $table->string('plate_number')->nullable();
            $table->integer('num_passenger')->nullable();
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
        Schema::dropIfExists('logs');
    }
}
