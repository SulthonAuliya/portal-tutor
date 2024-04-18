<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('setting_bidang');
            $table->dropColumn('setting_interest');
            $table->tinyInteger('content_settings')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('setting_bidang')->default(0);
            $table->boolean('setting_interest')->default(0);
            $table->dropColumn('content_settings');
        });
    }
};
