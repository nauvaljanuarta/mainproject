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
        $table->string('book_code', 20);
        $table->string('book_judul', 50);
        $table->string('book_pengarang', 200);
        $table->unsignedBigInteger('category_id');
        $table->string('create_by', 30);
        $table->string('update_by', 30);
        $table->timestamps();
        $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
