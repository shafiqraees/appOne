<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cms_side_bar_id');
            $table->text('content')->comment('as like about-us,marketing etc');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('cms_side_bar_id')->references('id')->on('cms_side_bars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_types');
    }
}
