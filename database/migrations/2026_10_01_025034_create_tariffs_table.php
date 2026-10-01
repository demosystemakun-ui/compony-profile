<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->string('tag');                       // Domestic / International / Others
            $table->string('title');                     // Domestic Tariffs
            $table->text('description')->nullable();
            $table->string('icon')->default('document'); // building | globe | document
            $table->string('pdf_path')->nullable();      // path di disk "public"
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tariffs');
    }
};