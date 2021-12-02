<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetapenggajiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metapenggajians', function (Blueprint $table) {
            $table->id();
            $table->integer('nominal');
            $table->enum('status', ['in', 'out']);
            $table->string('keterangan');
            $table->unsignedBigInteger('penggajian_id');
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
        Schema::dropIfExists('metapenggajians');
    }
}
