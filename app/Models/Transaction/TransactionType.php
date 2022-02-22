<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionType extends Model
{
    use HasFactory,
        SoftDeletes;
    protected $table='transaction_type';
    protected $fillable=[
        'title',
        'max_payment',
        'min_payment',
        'max_time'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(
            Transaction::class,
            'type_id',
            'id'
        )->orderBy('id','DESC');
    }
}
