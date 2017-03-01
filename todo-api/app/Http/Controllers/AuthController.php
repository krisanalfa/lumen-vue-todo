<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Login.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($user = User::where('email', $request->email)->first()) {
            if (app('hash')->check($request->password, $user->password)) {
                if (!$user->api_token) {
                    $user->api_token = str_random(128);
                    $user->save();
                }

                return [
                    'message' => 'Successfully login.',
                    'data' => $user
                ];
            }
        }

        return new JsonResponse([
            'message' => 'Wrong email or password.'
        ], 400);
    }

    /**
     * Logout.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        $user->api_token = '';

        $user->save();

        return [
            'message' => 'Successfully logout.'
        ];
    }
}
