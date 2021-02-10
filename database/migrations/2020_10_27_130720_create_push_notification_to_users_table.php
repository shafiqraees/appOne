<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePushNotificationToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_notification_to_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('push_notification_id');
            $table->unsignedBigInteger('user_profile_id')->comment('user profile id');
            $table->enum('status',['sent','pending'])->default('sent');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('push_notification_id')->references('id')->on('push_notifications')->onDelete('cascade');
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
        Schema::dropIfExists('push_notification_to_users');
    }
}
