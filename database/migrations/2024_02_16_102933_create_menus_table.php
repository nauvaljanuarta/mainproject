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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_level');
            $table->string('menu_name', 300);
            $table->string('menu_link', 300);
            $table->string('menu_icon', 300);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('create_by', 30);
            $table->string('delete_mark',1);
            $table->string('update_by', 30);
            $table->timestamps();

            $table->foreign('id_level')->references('id')->on('menu_levels');
            $table->foreign('parent_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
