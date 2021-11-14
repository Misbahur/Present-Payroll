<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelompokKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelompok_kerjas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('id_pola_kerja');
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
        Schema::dropIfExists('kelompok_kerjas');
    }
}
