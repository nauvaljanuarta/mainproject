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
        Schema::create('emiten', function (Blueprint $table) {
            $table->string('stock_code', 4)->primary();
            $table->string('stock_name', 100);
            $table->decimal('shared', 20, 4);
            $table->string('sektor', 100);
            $table->timestamps();
        });
        Schema::create('transaksi_harian', function (Blueprint $table) {
            $table->bigIncrements('no_records')->primary();
            $table->string('stock_code', 4);
            $table->date('date_transaction');
            $table->decimal('open', 20, 4);
            $table->decimal('high', 20, 4);
            $table->decimal('low', 20, 4);
            $table->decimal('close', 20, 4);
            $table->decimal('changes', 20, 4);
            $table->bigInteger('volume');
            $table->bigInteger('value');
            $table->integer('frequency');
            $table->timestamps();

            $table->foreign('stock_code')->references('stock_code')->on('emiten')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emiten');
        Schema::dropIfExists('transaksi_harian');
    }
};
