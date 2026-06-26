<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\PasswordResetNotification;

class PasswordResetController extends Controller
{
	public function showForgotForm()
	{
		return view('auth.forgot-password');
	}

	public function forgotPassword(Request $request)
	{
		$email = $request->input('email');
		$user = User::where('email', $email)->first();

		if ($user) {
			$token = Str::random(64);
			$expiresAt = now()->addHours(1);

			DB::table('password_reset_tokens')->updateOrInsert(
				['email' => $email],
				['token' => Hash::make($token), 'created_at' => now(), 'expires_at' => $expiresAt]
			);

			$user->notify(new PasswordResetNotification($token, $email));
		}

		return redirect()->route('login')->with('status', 'If an account exists for that email, a password reset link has been sent.');
	}

	public function showResetForm($email, $token)
	{
		$tokenRecord = DB::table('password_reset_tokens')
			->where('email', $email)
			->first();

		if (!$tokenRecord || !Hash::check($token, $tokenRecord->token) || now()->isAfter($tokenRecord->expires_at)) {
			return redirect()->route('login')->with('error', 'This password reset link is invalid or has expired.');
		}

		return view('auth.reset-password', ['email' => $email, 'token' => $token]);
	}

	public function resetPassword(ResetPasswordRequest $request)
	{
		$email = $request->input('email');
		$token = $request->input('token');
		$password = $request->input('password');

		$tokenRecord = DB::table('password_reset_tokens')
			->where('email', $email)
			->first();

		if (!$tokenRecord || !Hash::check($token, $tokenRecord->token) || now()->isAfter($tokenRecord->expires_at)) {
			return back()->with('error', 'This password reset link is invalid or has expired.');
		}

		$user = User::where('email', $email)->first();
		if (!$user) {
			return back()->with('error', 'User not found.');
		}

		$user->password = Hash::make($password);
		$user->save();

		$user->revokeAllSessions();

		DB::table('password_reset_tokens')->where('email', $email)->delete();

		return redirect()->route('login')->with('status', 'Password reset successful. Please log in with your new password.');
	}
}
