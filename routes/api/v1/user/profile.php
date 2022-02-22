<?php


use App\Models\User;
use App\Http\Resources\V1\User\User as UserResource;
use Illuminate\Support\Facades\Route;

Route::get('user/{user}/profile',function (User $user){
    return new UserResource($user);
});
