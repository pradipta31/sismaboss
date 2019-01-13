<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('periode_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('username');
            $table->string('nim')->unique();
            $table->string('email')->unique();
            $table->string('role');
            $table->string('password');
            $table->date('tgl_lahir')->nullable();
            $table->char('jenis_kelamin',1)->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('pict')->nullable();
            $table->boolean('status')->default(0);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('periode_id')->references('id')->on('periodes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
