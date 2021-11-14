<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolaKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pola_kerjas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamp('jam_masuk')->nullable();
            $table->timestamp('jam_istirahat')->nullable();
            $table->timestamp('jam_masuk_istirahat')->nullable();
            $table->timestamp('jam_pulang')->nullable();
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
        Schema::dropIfExists('pola_kerjas');
    }
}
