<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKehadiransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kehadirans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->nullable();
            $table->timestamp('jam_masuk')->nullable();
            $table->timestamp('jam_istirahat')->nullable();
            $table->timestamp('jam_masuk_istirahat')->nullable();
            $table->timestamp('jam_pulang')->nullable();
            $table->foreignId('id_pegawai');
            $table->foreignId('id_jabatan');
            // $table->foreignId('id_pola_kerja');
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
        Schema::dropIfExists('kehadirans');
    }
}
