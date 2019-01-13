<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absent_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('absent_id')->unsigned();
            $table->integer('member_id')->unsigned();
            $table->timestamps();

            $table->foreign('absent_id')->references('id')->on('absents')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('member_id')->references('id')->on('members')
            ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absent_details');
    }
}
