<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('follow_by_id')->comment('the person who follow your profile');
            $table->unsignedBigInteger('follow_to_id')->comment('the person which you are following');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('follow_by_id')->references('id')->on('user_profiles')->onDelete('cascade');
            $table->foreign('follow_to_id')->references('id')->on('user_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('followers');
    }
}
