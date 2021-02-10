<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewStatusToPostViewersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_viewers', function (Blueprint $table) {
            $table->enum('view_status', ['true', 'false'])->default('true')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_viewers', function (Blueprint $table) {
            $table->dropColumn('view_status');
        });
    }
}
