<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\GetAuthenticatedUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function __invoke(Request $request, GetAuthenticatedUser $action): JsonResponse
    {
        $user = $action($request);

        return response()->json([
            'message' => 'User profile retrieved',
            'data' => $user,
        ]);
    }
}
