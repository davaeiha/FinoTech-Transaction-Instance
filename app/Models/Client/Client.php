<?php

namespace App\Models\Client;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Client extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='client';
    protected $fillable=[
        'id',
        'name',
        'description',
        'scope'
    ];
    public $incrementing=false;
    protected $keyType='string';

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($client){
            $client->id = Str::uuid();
        });
    }

    public function clientUser(): HasMany
    {
        return $this->hasMany(
            ClientUser::class,
            'client_id',
            'id'
        )->orderBy('id','DESC');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            Client::class,
            'client_user',
            'user_id',
            'client_id'
        );
    }

}
