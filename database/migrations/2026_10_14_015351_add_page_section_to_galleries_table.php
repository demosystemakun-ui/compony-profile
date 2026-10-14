<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('page')->default('operations')->after('title');
            $table->string('section')->default('gallery')->after('page');
            $table->integer('sort_order')->default(0)->after('section');
        });
    }

    public function down()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn(['page', 'section', 'sort_order']);
        });
    }
};