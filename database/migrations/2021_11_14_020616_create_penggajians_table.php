<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggajiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penggajians', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->integer('nominal');
            $table->enum('status', ['in', 'out']);
            $table->string('keterangan');
            $table->foreignId('id_pegawai');
            $table->foreignId('id_jabatan');
            $table->foreignId('id_komponen_gaji');
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
        Schema::dropIfExists('penggajians');
    }
}
