<?php

namespace App\Models\Bank;

use App\Enums\BankType;
use App\Enums\BankTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    use HasFactory;
    protected $table='bank';
    protected $fillable=[
        'title',
        'type'
    ];

    protected $casts=[
        'type'=>BankTypeEnum::class,
    ];

    public function accounts(): HasMany
    {
        return $this->hasMany(
            Account::class,
            'bank_id',
            'id'
        )->orderBy('id','DESC');
    }
}
