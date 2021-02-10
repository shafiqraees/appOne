<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdveriseWithUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adverise_with_us', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('discription')->nullable();
            $table->text('image')->nullable();
            $table->enum('status', ['publish', 'unPublish'])->default('publish')->nullable();
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
        Schema::dropIfExists('adverise_with_us');
    }
}
