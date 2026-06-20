<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LoginUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request, LoginUser $action): JsonResponse
    {
        $result = $action($request);

        return response()->json([
            'message' => 'Login successful',
            'data' => [
                'token' => $result['token'],
                'user' => $result['user'],
            ],
        ]);
    }
}
