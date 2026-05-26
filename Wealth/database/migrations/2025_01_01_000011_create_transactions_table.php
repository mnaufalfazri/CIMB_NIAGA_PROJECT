<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account_id');
            $table->string('reference_id', 50)->unique();
            $table->enum('direction', ['credit', 'debit']);
            $table->enum('transaction_type', [
                'transfer',
                'payment',
                'topup',
                'withdraw',
                'deposit',
                'admin_fee',
                'initial',
                'refund',
                'reversal',
            ]);
            $table->decimal('amount', 15, 2);
            $table->decimal('balance_before', 15, 2);
            $table->decimal('balance_after', 15, 2);
            $table->enum('status', ['pending', 'success', 'failed', 'reversed'])->default('success');
            $table->string('description', 255)->nullable();
            $table->string('counterparty_account', 13)->nullable();
            $table->string('counterparty_name', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('account_id', 'fk_transactions_account')
                ->references('id')->on('accounts')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('account_id', 'idx_account_id');
            $table->index('reference_id', 'idx_reference_id');
            $table->index('created_at', 'idx_created_at');
            $table->index(['account_id', 'created_at'], 'idx_account_created');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
