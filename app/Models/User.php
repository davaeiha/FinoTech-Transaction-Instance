<?php

namespace App\Models;

use App\Models\Bank\Account;
use App\Models\Client\ClientUser;
use App\Models\Transaction\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'scopes',
        'password',
        'finotech_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'scopes'=> 'array'
    ];

    public function accounts(): HasMany
    {
        return $this->hasMany(
            Account::class,
            'user_id',
            'id'
        )->orderBy('id','DESC');
    }

    public function clientUser(): HasMany
    {
        return $this->hasMany(
            ClientUser::class,
            'user_id',
            'id'
        )->orderBy('id','DESC');
    }

    public function transactions_as_source(): HasManyThrough
    {
        return $this->hasManyThrough(
            Transaction::class,
            Account::class,
            'user_id',
            'source_account_id',
            'id',
            'id'
        );
    }

    public function transactions_as_destination(): HasManyThrough
    {
        return $this->hasManyThrough(
            Transaction::class,
            Account::class,
            'user_id',
            'destination_account_id',
            'id',
            'id'
        );
    }
}
