<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->text('image')->nullable();
            $table->enum('type',['motorcycle','car','truck','van','tricycle']);
            $table->enum('tag',['public','private']);
            $table->foreignId('user_id');
            $table->string('make');
            $table->string('model');
            $table->string('color');
            $table->string('plate_number');
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
        Schema::dropIfExists('vehicles');
    }
}
