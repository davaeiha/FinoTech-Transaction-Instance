<?php

namespace App\Models\Bank;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory,
        SoftDeletes;
    protected $table='bank_account';
    protected $fillable=[
        'account_no',
        'sheba_no',
        'payment_no'
    ];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(
            Bank::class,
            'bank_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}
