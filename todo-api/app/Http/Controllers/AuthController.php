<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Container\Container;

class AuthController extends Controller
{
    /**
     * Login.
     *
     * @param Container $app
     * @param Request   $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Container $app, Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($user = User::where('email', $request->email)->first()) {
            if ($app->make('hash')->check($request->password, $user->password)) {
                // If we haven't generate the token...
                if (!$user->api_token) {
                    $user->api_token = Str::random(128);
                    $user->save();
                }

                return new JsonResponse([
                    'message' => 'Successfully login.',
                    'data' => $user,
                ]);
            }
        }

        return new JsonResponse([
            'message' => 'Wrong email or password.',
        ], 400);
    }

    /**
     * Logout.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        $user->api_token = '';

        $user->save();

        return new JsonResponse([
            'message' => 'Successfully logout.',
        ]);
    }
}
