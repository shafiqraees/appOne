<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddHashTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_hash_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_profile_id');
            $table->unsignedBigInteger('adds_marketing_id');
            $table->unsignedBigInteger('hash_tag_id');
            $table->enum('status', ['active', 'deActive'])->default('active')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_profile_id')->references('id')->on('user_profiles')->onDelete('cascade');
            $table->foreign('adds_marketing_id')->references('id')->on('adds_marketings')->onDelete('cascade');
            $table->foreign('hash_tag_id')->references('id')->on('hash_tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_hash_tags');
    }
}
