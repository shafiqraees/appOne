<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('view_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('social_status_id');
            $table->unsignedBigInteger('user_profile_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('is_viewed', ['true', 'false'])->default('false');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('social_status_id')->references('id')->on('social_statuses')->onDelete('cascade');
            $table->foreign('user_profile_id')->references('id')->on('user_profiles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_statuses');
    }
}
