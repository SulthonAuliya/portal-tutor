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
        Schema::table('post_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id')->after('id');
            $table->unsignedBigInteger('category_id')->nullable()->after('post_id');

            $table->foreign('post_id')->references('id')->on('post')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_categories', function (Blueprint $table) {
            $table->dropForeign('post_id');
            $table->dropForeign('category_id');
            $table->dropColumn('post_id');
            $table->dropColumn('category_id');
        });
    }
};
