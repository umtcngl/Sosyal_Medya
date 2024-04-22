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
        Schema::table('kullanicilar', function (Blueprint $table) {
            // Hesabı gizliye almak için boolean bir sütun ekleyelim ve varsayılan değeri false olarak atayalım
            $table->boolean('gizli')->default(false);

            // Kullanıcı açıklaması için varchar(255) bir sütun ekleyelim ve varsayılan değeri null olarak ayarlayalım
            $table->string('aciklama')->nullable();

            // Profil resmi için varchar(255) bir sütun ekleyelim ve varsayılan değeri null olarak ayarlayalım
            $table->string('profil_resmi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kullanicilar', function (Blueprint $table) {
            // Eklediğimiz sütunları kaldırmak için down metodu
            $table->dropColumn('gizli');
            $table->dropColumn('aciklama');
            $table->dropColumn('profil_resmi');
        });
    }
};
