<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTakipIstekleriTable extends Migration
{
    public function up()
    {
        Schema::create('takip_istekleri', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('takip_eden_id');
            $table->unsignedBigInteger('takip_edilen_id');
            $table->boolean('onaylandi_mi')->default(false);
            $table->boolean('iptal_edildi_mi')->default(false);
            $table->timestamps();

            $table->foreign('takip_eden_id')->references('id')->on('kullanicilar')->onDelete('cascade');
            $table->foreign('takip_edilen_id')->references('id')->on('kullanicilar')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('takip_istekleri');
    }
}
