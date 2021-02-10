<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddImpresssionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_impresssions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('adds_marketing_id');
            $table->unsignedBigInteger('user_profile_id')->comment('user profile id');
            $table->enum('is_view',['true','false'])->default('false');
            $table->enum('sex',['male','female'])->nullable();
            $table->enum('is_click',['true','false'])->default('false');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('adds_marketing_id')->references('id')->on('adds_marketings')->onDelete('cascade');
            $table->foreign('user_profile_id')->references('id')->on('user_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_impresssions');
    }
}
