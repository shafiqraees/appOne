<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddsMarketingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adds_marketings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_profile_id')->nullable()->comment('buisness profile id');
            $table->unsignedBigInteger('user_id')->comment('main user id');
            $table->string('name');
            $table->unsignedBigInteger('add_number');
            $table->string('add_date')->nullable();
            $table->text('video');
            $table->text('description')->nullable();
            $table->text('banner')->nullable();
            $table->enum('gender',['male','female','sheMale'])->nullable();
            $table->string('age_from')->nullable();
            $table->string('age_to')->nullable();
            $table->text('location')->nullable();
            $table->string('radious')->nullable();
            $table->string('impressions')->nullable();
            $table->string('funds_from')->nullable();
            $table->string('funds_to')->nullable();
            $table->string('end_date')->nullable();
            $table->string('end_on_budget_end')->nullable();
            $table->enum('status',['visible','pause','cancell'])->default('visible');
            $table->enum('add_status',['active','deActive'])->default('active');
            $table->softDeletes();
            $table->timestamps();
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
        Schema::dropIfExists('adds_marketings');
    }
}
