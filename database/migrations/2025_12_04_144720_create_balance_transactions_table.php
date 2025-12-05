<?php

use App\Enums\Transaction\TransactionType;
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
        Schema::create('balance_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->cascadeOnDelete();

            $table->enum('type', [
                TransactionType::DEPOSIT->value,
                TransactionType::WITHDRAW->value,
                TransactionType::TRANSFER_IN->value,
                TransactionType::TRANSFER_OUT->value
            ]);

            $table->decimal('amount', 15);

            // To link two transfer transactions
            $table->uuid('batch_uuid')->nullable()->index();

            // To link transfer_out -> transfer_in
            $table->foreignId('related_transaction_id')
                ->nullable()
                ->constrained('balance_transactions')
                ->nullOnDelete();

            $table->string('comment')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            // Indexes for fast queries
            $table->index(['account_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balance_transactions');
    }
};
