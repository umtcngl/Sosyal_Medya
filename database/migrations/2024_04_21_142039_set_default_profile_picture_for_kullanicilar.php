<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Önce null olan tüm verileri güncelleyin
        DB::table('kullanicilar')
          ->whereNull('profil_resmi')
          ->update(['profil_resmi' => 'images/profil_resmi/default.png']);

        // Şimdi sütun tanımını değiştirin
        Schema::table('kullanicilar', function (Blueprint $table) {
            $table->string('profil_resmi')->default('images/profil_resmi/default.png')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kullanicilar', function (Blueprint $table) {
            $table->string('profil_resmi')->nullable()->default(null)->change();
        });
    }
};
