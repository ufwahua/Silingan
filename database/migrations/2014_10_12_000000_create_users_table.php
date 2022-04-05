<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('block_lot_id')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender');
            $table->integer('age');
            $table->string('contact_num');
            $table->text('profile_pic')->nullable();
            $table->boolean('has_voted');
            $table->boolean('verified');
            $table->enum('status', ['active', 'inactive'])->nullable();
            $table->enum('role', ['admin', 'officer', 'resident', 'security_officer']);






            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
