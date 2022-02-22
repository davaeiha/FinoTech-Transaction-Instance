<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\User\User as UserResource;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use function auth;
use function bcrypt;
use function response;

class AuthController extends Controller
{
    /**
     * register user
     *
     * @param Request $request
     * @return UserResource
     */
    public function register(Request $request)
    {
        $validData = $request->validate([
            'username'=>'required|string',
            'email'=>'required|email',
            'password'=>'required|min:6',
            'password_confirmation'=>'required|same:password'
        ]);

        $user = User::query()->create([
            'username'=>$validData['username'],
            'email'=>$validData['email'],
            'password'=>bcrypt($validData['password']),
        ]);

        $token = $user->createToken('Auth Token')->accessToken;
//        \event(new Registered($user));
        return new UserResource($user,$token,200);

    }


    public function login(Request $request): Response|UserResource|Application|ResponseFactory
    {

        $validData = $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        if(! auth()->attempt($validData)) {
            return response([
                'status' => 'INVALID_CREDENTIAL',
                'message' => 'invalid login credential',
            ],403);
        }

        auth()->user()->tokens()->delete();
        $token = auth()->user()->createToken('Auth Token')->accessToken;

        return new UserResource(auth()->user(),$token);

    }

    /**
     * logout user
     *
     * @return Application|ResponseFactory|Response|string[]
     */
    public function logout(): array|Response|Application|ResponseFactory
    {
        if (!auth()->check()) {
            return [
                'status' => 'NOT_AUTHENTICATED',
                'message' => 'Not Authenticated',
            ];
        }
        // revoke user's token
        auth()->user()->token()->revoke();

        return response([
            'status' => 'TOKEN_REVOKED',
            'message' => 'Your session has been terminated',
        ],200);
    }
}
