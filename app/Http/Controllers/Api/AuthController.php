<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return response()->json(['message' => 'The provided credentials are incorrect.'], 422);
        }

        $request->session()->regenerate();
        $user = $request->user();

        $user->activityEvents()->create(['event' => 'login']);

        $expiredEventIds = $user->activityEvents()
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get()
            ->skip(100)
            ->pluck('id');

        $user->activityEvents()->whereKey($expiredEventIds)->delete();

        return response()->json(['user' => $user->only(['id', 'name', 'email'])]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
