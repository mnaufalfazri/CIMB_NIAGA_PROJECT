<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('failed_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_id', 50)->unique();
            $table->json('payload');
            $table->text('error_message')->nullable();
            $table->integer('retry_count')->default(0);
            $table->enum('status', ['pending', 'retried', 'resolved', 'dead'])->default('pending');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('failed_transactions');
    }
};
