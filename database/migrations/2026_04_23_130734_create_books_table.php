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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("ISBN");
            $table->string("title");
            $table->string("description");
            $table->date("published_date");
            $table->foreignId("category_id")->constrained()->cascadeOnDelete();
            $table->foreignId("author_id")->constrained()->cascadeOnDelete();
            $table->text("book_upload")->nullable();
            $table->text("image")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
