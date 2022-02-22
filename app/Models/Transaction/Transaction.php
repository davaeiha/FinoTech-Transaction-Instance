<?php

namespace App\Models\Transaction;

use App\Enums\ReasonEnum;
use App\Enums\StatusEnum;
use App\Models\Bank\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\TransactionTypeEnum;

class Transaction extends Model
{
    use HasFactory,
        SoftDeletes;
    protected $table='transaction';
    protected $fillable=[
        'source_account_id',
        'destination_account_id',
        'payment_time',
        'ref_code',
        'amount',
        'description',
        'reason',
        'type_id',
        'status'
    ];

    protected $casts=[
        'reason'=>ReasonEnum::class,
        'status'=>StatusEnum::class,
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(
            TransactionType::class,
            'type_id'
        );
    }

    public function sourceAccount(): BelongsTo
    {
        return $this->belongsTo(
            Account::class,
            'source_account_id'
        );
    }

    public function destAccount(): BelongsTo
    {
        return $this->belongsTo(
            Account::class,
            'destination_account_id'
        );
    }

}
