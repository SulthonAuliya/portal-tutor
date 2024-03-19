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
        Schema::table('tutor_session', function (Blueprint $table) {
            $table->unsignedBigInteger('tutor_id')->after('id');
            $table->unsignedBigInteger('post_id')->nullable()->after('tutor_id');

            $table->foreign('tutor_id')->references('id')->on('users')->onDelete('cascade')->after('id');
            $table->foreign('post_id')->references('id')->on('post')->onDelete('cascade')->nullable()->after('tutor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tutor_session', function (Blueprint $table) {
            $table->dropForeign('tutor_id');
            $table->dropForeign('post_id');
            $table->dropColumn('tutor_id');
            $table->dropColumn('post_id');

        });
    }
};
