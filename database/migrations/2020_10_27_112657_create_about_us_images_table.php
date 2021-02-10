<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutUsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_us_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cms_type_id');
            $table->text('image')->nullable()->comment('all images here');
            $table->string('name')->nullable()->comment('all images here');
            $table->enum('toturial_type', ['user', 'buisness'])->default('user')->nullable();
            $table->enum('status', ['publish', 'unPublish'])->default('publish')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('cms_type_id')->references('id')->on('cms_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('about_us_images');
    }
}
