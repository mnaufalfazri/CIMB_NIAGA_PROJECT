<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('user_name', 100)->nullable();
            $table->string('nomor_rekening', 13)->unique();
            $table->enum('account_type', ['saving', 'business', 'deposit'])->default('saving');
            $table->char('currency', 3)->default('IDR');
            $table->decimal('balance', 15, 2)->default(1000000.00);
            $table->enum('status', ['active', 'frozen', 'closed'])->default('active');
            $table->unsignedBigInteger('version')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->index('user_id', 'idx_user_id');
            $table->index('nomor_rekening', 'idx_nomor_rekening');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
