<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Generate password reset token using the User model's method
        $resetToken = $notifiable->generatePasswordResetToken();

        $resetUrl = route('reset-password', [
            'email' => $notifiable->email,
            'token' => $resetToken,
        ]);

        return (new MailMessage)
            ->subject('Reset Your Password')
            ->greeting("Hello {$notifiable->name},")
            ->line('We received a request to reset your password. Click the button below to proceed.')
            ->action('Reset Password', $resetUrl)
            ->line('If you did not request a password reset, you can safely ignore this email.')
            ->line('This password reset link will expire in 1 hour.')
            ->line('Alternatively, you can copy and paste this link in your browser:')
            ->line($resetUrl);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
