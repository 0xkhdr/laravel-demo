<?php

namespace App\Support;

use App\Models\User;

class AuditLogger
{
    /**
     * Log a login event.
     *
     * @param User $user
     * @param string $ip
     * @return void
     */
    public static function login(User $user, string $ip): void
    {
        // TODO: Log login action to AuditLog table
        // AuditLog::create([
        //     'user_id' => $user->id,
        //     'action' => 'login',
        //     'ip_address' => $ip,
        //     'user_agent' => request()->userAgent(),
        // ]);
    }

    /**
     * Log a logout event.
     *
     * @param User $user
     * @param string $ip
     * @return void
     */
    public static function logout(User $user, string $ip): void
    {
        // TODO: Log logout action to AuditLog table
        // AuditLog::create([
        //     'user_id' => $user->id,
        //     'action' => 'logout',
        //     'ip_address' => $ip,
        //     'user_agent' => request()->userAgent(),
        // ]);
    }

    /**
     * Log a password reset event.
     *
     * @param User $user
     * @param string $ip
     * @return void
     */
    public static function passwordReset(User $user, string $ip): void
    {
        // TODO: Log password_reset action to AuditLog table
        // AuditLog::create([
        //     'user_id' => $user->id,
        //     'action' => 'password_reset',
        //     'ip_address' => $ip,
        //     'user_agent' => request()->userAgent(),
        // ]);
    }

    /**
     * Log a password change event.
     *
     * @param User $user
     * @param string $ip
     * @return void
     */
    public static function passwordChange(User $user, string $ip): void
    {
        // TODO: Log password_change action to AuditLog table
        // AuditLog::create([
        //     'user_id' => $user->id,
        //     'action' => 'password_change',
        //     'ip_address' => $ip,
        //     'user_agent' => request()->userAgent(),
        // ]);
    }
}
