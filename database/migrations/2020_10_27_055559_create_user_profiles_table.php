<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('profile_name');
            $table->string('profile_email')->nullable();
            $table->text('profile_image')->nullable();
            $table->string('profile_phone')->nullable();
            $table->text('profile_address')->nullable();
            $table->string('profile_website')->nullable();
            $table->text('profile_about')->nullable();
            $table->text('profile_banner')->nullable();
            $table->enum('profile_type', ['business', 'social'])->default('social');
            $table->enum('profile_status', ['public', 'private'])->default('public');
            $table->enum('profile_is_suspend', ['true', 'false'])->default('false');
            $table->enum('notification_status', ['true', 'false'])->default('true');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('user_profiles');
    }
}
