<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Mark the user's email as verified.
     *
     * @return $this
     */
    public function verifyEmail(): self
    {
        $this->update(['email_verified_at' => now()]);
        return $this;
    }

    /**
     * Generate an email verification token and store it in the database.
     *
     * @return string The generated token
     */
    public function generateEmailVerificationToken(): string
    {
        $token = Str::random(40);
        $expiresAt = now()->addHours(24);

        DB::table('email_verification_tokens')->updateOrInsert(
            ['email' => $this->email],
            ['token' => $token, 'created_at' => now(), 'expires_at' => $expiresAt]
        );

        return $token;
    }

    /**
     * Generate a password reset token and store it in the database.
     *
     * @return string The generated token
     */
    public function generatePasswordResetToken(): string
    {
        $token = Str::random(40);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $this->email],
            ['token' => $token, 'created_at' => now()]
        );

        return $token;
    }

    /**
     * Revoke all sessions for this user.
     *
     * @return void
     */
    public function revokeAllSessions(): void
    {
        DB::table('sessions')->where('user_id', $this->id)->delete();
    }
}
