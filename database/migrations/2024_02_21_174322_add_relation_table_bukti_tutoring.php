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
        Schema::table('bukti_tutoring', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            $table->unsignedBigInteger('tutoring_id')->after('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->after('id');
            $table->foreign('tutoring_id')->references('id')->on('tutor_session')->onDelete('cascade')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bukti_tutoring', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('tutoring_id');
            $table->dropColumn('user_id');
            $table->dropColumn('tutoring_id');
        });
    }
};
