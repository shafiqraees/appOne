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
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('user_type');
            $table->string('device_id')->nullable();
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('org_password')->nullable();
            $table->text('address')->nullable();
            $table->text('about')->nullable();
            $table->enum('status', ['Married', 'Unmarried'])->default('Unmarried');
            $table->string('device_token')->nullable();
            $table->enum('is_active', ['true', 'false'])->default('true');
            $table->enum('notification_status', ['true', 'false'])->default('true');
            $table->string('remaining_credit')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
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
