<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEngellenenKullanicilarTable extends Migration
{
    public function up()
    {
        Schema::create('engellenen_kullanicilar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('engelleyen_kullanici_id');
            $table->unsignedBigInteger('engellenen_kullanici_id');
            $table->timestamps();

            $table->foreign('engelleyen_kullanici_id')->references('id')->on('kullanicilar');
            $table->foreign('engellenen_kullanici_id')->references('id')->on('kullanicilar');
        });
    }

    public function down()
    {
        Schema::dropIfExists('engellenen_kullanicilar');
    }
}
