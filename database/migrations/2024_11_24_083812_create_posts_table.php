<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->unsignedBigInteger('category_id');
            $table->string('image')->nullable();
            $table->string('title');
            $table->longText('content');
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->restrictOnDelete();
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
