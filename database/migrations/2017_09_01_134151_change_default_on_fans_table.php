<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDefaultOnFansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fans', function (Blueprint $table) {
            Schema::table('fans', function ($table) {
                $table->integer('fan_id')->default(0)->change();//粉丝id
                $table->integer('star_id')->default(0)->change();//明星id
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fans', function (Blueprint $table) {
            //
        });
    }
}
