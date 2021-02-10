<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('private_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requested_profile')->comment('the person who request to follow');
            $table->unsignedBigInteger('private_profile')->comment('the person which you are requesting to follow him');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('requested_profile')->references('id')->on('user_profiles')->onDelete('cascade');
            $table->foreign('private_profile')->references('id')->on('user_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('private_profiles');
    }
}
