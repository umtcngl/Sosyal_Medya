<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kullanicilar', function (Blueprint $table) {
            $table->string('role')->default('user'); // Varsayılan olarak 'user' rolü atanacak
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kullanicilar', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
}
