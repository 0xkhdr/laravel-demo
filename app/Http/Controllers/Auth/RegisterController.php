<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request, RegisterUser $action): JsonResponse
    {
        $user = $action($request);

        return response()->json([
            'message' => 'User registered successfully',
            'data' => $user,
        ], 201);
    }
}
