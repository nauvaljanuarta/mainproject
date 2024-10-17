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
        Schema::create('setting_menu_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jenis_user');
            $table->unsignedBigInteger('menu_id');
            $table->string('create_by', 30);
            $table->string('delete_by', 1);
            $table->string('update_by', 30);
            $table->timestamps();

            $table->foreign('id_jenis_user')->references('id')->on('jenis_users');
            $table->foreign('menu_id')->references('id')->on('menus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_menu_users');
    }
};
