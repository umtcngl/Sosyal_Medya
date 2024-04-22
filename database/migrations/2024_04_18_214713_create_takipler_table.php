<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('takipler', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('takipci_id');
            $table->unsignedBigInteger('takip_edilen_id');
            $table->timestamps();

            // Takip eden kullanıcı ile kullanicilar tablosu arasında foreign key ilişkisi
            $table->foreign('takipci_id')->references('id')->on('kullanicilar')->onDelete('cascade');

            // Takip edilen kullanıcı ile kullanicilar tablosu arasında foreign key ilişkisi
            $table->foreign('takip_edilen_id')->references('id')->on('kullanicilar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('takipler');
    }
};
