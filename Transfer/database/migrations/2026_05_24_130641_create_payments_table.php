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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_rekening', 13);
            $table->enum('biller_category', ['pln', 'pdam', 'internet']);
            $table->string('customer_number', 50);
            $table->decimal('amount', 15, 2);
            $table->decimal('admin_fee', 15, 2)->default(2500);
            $table->enum('status', ['pending', 'completed', 'failed']);
            $table->string('reference_id', 50)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
