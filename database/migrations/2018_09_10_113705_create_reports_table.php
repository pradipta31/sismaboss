<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('periode_id')->unsigned();
            $table->integer('letter_id')->unsigned()->nullable();
            $table->integer('fund_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->string('judul_laporan')->unique();
            $table->date('tanggal');
            $table->text('deskripsi');
            $table->timestamps();

            $table->foreign('periode_id')->references('id')->on('periodes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('letter_id')->references('id')->on('letters')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fund_id')->references('id')->on('funds')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
