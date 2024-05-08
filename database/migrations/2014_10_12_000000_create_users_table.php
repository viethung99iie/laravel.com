<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('name');
            $table->string('phone',50)->nullable();
            $table->string('province_id',10)->nullable();
            $table->string('district_id',10)->nullable();
            $table->string('ward_id',10)->nullable();
            $table->string('address')->nullable();
            $table->string('image')->nullable();
            $table->date('birthday')->nullable();
            $table->text('description')->nullable();
            $table->text('user_agent')->nullable();
            $table->text('ip')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
};
