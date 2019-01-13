<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('periode_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('jenis')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('debit')->nullable();
            $table->string('kredit')->nullable();
            $table->string('saldo')->nullable();
            $table->string('nominal')->nullable();
            $table->text('keterangan');
            $table->timestamps();

            $table->foreign('periode_id')->references('id')->on('periodes')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('funds');
    }
}
