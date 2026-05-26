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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->string('sender_nomor_rekening', 13);
            $table->string('receiver_nomor_rekening', 13);
            $table->string('receiver_name', 100);
            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 15, 2)->default(0);
            $table->enum('transfer_type', ['intra_bank', 'inter_bank_bifast']);
            $table->enum('status', ['pending', 'completed', 'failed']);
            $table->string('description', 255)->nullable();
            $table->string('reference_id', 50)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
