<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');          // Contoh: Vehicle Lineup
            $table->string('tag');            // Contoh: CBU Units
            $table->string('date_info');      // Contoh: Quality Control
            $table->string('location');       // Contoh: Inspection Area
            $table->text('description');      // Deskripsi gambar
            $table->string('image');          // Path gambar
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('galleries');
    }
};