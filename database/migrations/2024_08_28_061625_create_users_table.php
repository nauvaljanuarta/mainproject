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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_user', 60);
            $table->string('username', 60);
            $table->string('password', 60);
            $table->string('email', 200)->unique();
            $table->string('no_hp', 30)->nullable();
            $table->unsignedBigInteger('id_jenis_user')->default(2);
            $table->string('status_user', 30);
            $table->string('delete_mark', 1);
            $table->string('create_by', 30);
            $table->string('update_by', 30);
            $table->timestamps();

            $table->foreign('id_jenis_user')->references('id')->on('jenis_users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
