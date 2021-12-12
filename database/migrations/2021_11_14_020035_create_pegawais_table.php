<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->integer('nik')->nullable();
            $table->string('nama');
<<<<<<< HEAD
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat')->nullable();
            $table->string('nohp')->nullable();
=======
            $table->integer('nohp')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat')->nullable();
>>>>>>> c61ac8db5f08413364053620eaf3cf59708e1f92
            $table->date('tanggal_masuk')->nullable();
            $table->unsignedBigInteger('jabatan_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawais');
    }
}
