<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporaries', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('status', ['in-lembur-harian', 'out-telat-harian', 'out-istirahat', 'out-istirahat-masuk', 'out-absen-harian', 'in-bonus-mingguan', 'in-bonus-bulanan', 'in-bonus-libur-masuk' ]);
            // $table->string('status');
            $table->integer('nominal');
            // $table->string('keterangan');
            // $table->unsignedBigInteger('lembur_id');
            $table->unsignedBigInteger('pegawai_id');
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
        Schema::dropIfExists('temporaries');
    }
}
