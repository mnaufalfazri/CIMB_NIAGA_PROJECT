<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('account_balance_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account_id');
            $table->decimal('old_balance', 15, 2);
            $table->decimal('new_balance', 15, 2);
            $table->string('reference_id', 50)->nullable();
            $table->enum('action_type', ['credit', 'debit', 'adjustment']);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('account_id', 'fk_balance_logs_account')
                ->references('id')->on('accounts')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('account_id', 'idx_balance_logs_account');
            $table->index('reference_id', 'idx_balance_logs_reference');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_balance_logs');
    }
};
