<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCommentsLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_comments_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_comment_id');
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_profile_id');
            $table->enum('is_like', ['true', 'false'])->default('true')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('post_comment_id')->references('id')->on('post_comments')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
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
        Schema::dropIfExists('post_comments_likes');
    }
}
