<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('periode_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('judul_rapat');
            $table->date('tgl_rapat');
            $table->text('hasil_rapat');
            $table->string('jumlah_hadir');
            $table->string('moderator');
            $table->timestamps();
            
            $table->foreign('periode_id')->references('id')->on('periodes')->onDelete('cascade');
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
        Schema::dropIfExists('meetings');
    }
}
