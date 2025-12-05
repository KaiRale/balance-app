<?php

namespace App\Models;

use App\Enums\Transaction\TransactionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BalanceTransaction extends Model
{
    protected $fillable = [
        'account_id',
        'type',
        'amount',
        'batch_uuid',
        'related_transaction_id',
        'comment',
        'meta',
    ];

    protected $casts = [
        'type' => TransactionType::class,
        'amount' => 'decimal:2',
        'meta' => 'array',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
