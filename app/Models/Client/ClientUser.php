<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ClientUser extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='client_user';
    protected $fillable=[
        'client_id',
        'user_id',
        'trackId',
        'approach',
    ];

    protected $casts=[
        'approach'=>\ApproachEnum::class,
    ];

    protected $dates=[
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($clientUser){
            $clientUser->trackId = Str::uuid();
        });
    }

}
