<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBegenilerTable extends Migration
{
    public function up()
    {
        Schema::create('begeniler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gonderi_id')->constrained('gonderiler')->onDelete('cascade');
            $table->foreignId('kullanici_id')->constrained('kullanicilar')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['gonderi_id', 'kullanici_id']); // Her kullanıcı bir gönderiyi yalnızca bir kez beğenebilir
        });
    }

    public function down()
    {
        Schema::dropIfExists('begeniler');
    }
}
