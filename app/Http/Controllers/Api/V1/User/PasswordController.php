<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\User\User as UserResource;
use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    /**
     * update password
     *
     * @param Request $request
     * @return UserResource|void
     */
    public function updatePassword(Request $request){
        $user = User::query()->where('id', auth()->id())->first();
        if ($request->input('old_password') && Hash::check("{$request->input('old_password')}", $user->password)) {
            if ($request->input('new_password') === $request->input('password_confirmation')) {
                $user->password = Hash::make($request->input('new_password'));
                $user->save();
                return new UserResource($user,null,200);
            }
        }
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function forgotPassword(Request $request): Response|Application|ResponseFactory
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) abort(404);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        Mail::to($request->email)->send(new ForgotPassword($token, $user));

        return response([
            'data'=>[
                'token'=>$token,
                'email'=>$request->email,
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) abort(404);

        $passwordReset = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token,
                'deleted_at' => null
            ])
            ->first();

        if (!$passwordReset) abort(401);
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where(['email' => $request->email])
            ->update(['deleted_at' => now()]);

        return response()->json(true);
    }
}
