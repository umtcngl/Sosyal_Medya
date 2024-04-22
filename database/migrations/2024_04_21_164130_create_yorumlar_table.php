<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYorumlarTable extends Migration
{
    public function up()
    {
        Schema::create('yorumlar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gonderi_id')->constrained('gonderiler')->onDelete('cascade');
            $table->foreignId('kullanici_id')->constrained('kullanicilar')->onDelete('cascade'); // Dikkat: 'users' yerine 'kullanicilar'
            $table->text('icerik');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('yorumlar');
    }
}

