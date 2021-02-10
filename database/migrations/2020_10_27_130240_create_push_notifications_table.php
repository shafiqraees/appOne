<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePushNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('gender');
            $table->string('age_from')->nullable();
            $table->string('age_to')->nullable();
            $table->text('location')->nullable();
            $table->string('radius')->nullable();
            $table->string('titile')->nullable();
            $table->text('message')->nullable();
            $table->text('send_now')->nullable();
            $table->string('schedule_date_time')->nullable();
            $table->string('time')->nullable();
            $table->enum('status',['sent','pending','cancelled'])->default('sent');
            $table->softDeletes();
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
        Schema::dropIfExists('push_notifications');
    }
}
