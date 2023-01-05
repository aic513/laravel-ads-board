<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserPhoneAuth extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('phone_auth')->default(false)->after('phone');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone_auth');
        });
    }
}