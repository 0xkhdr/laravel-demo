<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LogoutUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __invoke(LogoutUser $action): JsonResponse
    {
        $user = Auth::user();
        $action($user);

        return response()->json([
            'message' => 'Logout successful',
        ]);
    }
}
