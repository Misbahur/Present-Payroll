<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonKasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bon_kas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('nominal');
            $table->string('keterangan');
            $table->date('tanggal');
            $table->foreignId('id_pegawai');
            $table->foreignId('id_jabatan');
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
        Schema::dropIfExists('bon_kas');
    }
}
