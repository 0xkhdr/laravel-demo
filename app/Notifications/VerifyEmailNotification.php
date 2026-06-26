<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification
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
        // Generate verification token using the User model's method
        $verificationToken = $notifiable->generateEmailVerificationToken();

        $verificationUrl = route('verify', [
            'email' => $notifiable->email,
            'token' => $verificationToken,
        ]);

        return (new MailMessage)
            ->subject('Verify Your Email Address')
            ->greeting("Hello {$notifiable->name},")
            ->line('Thank you for registering with us. Please verify your email address to complete your account setup.')
            ->action('Verify Email', $verificationUrl)
            ->line('If you did not create an account, you can safely ignore this email.')
            ->line('This verification link will expire in 24 hours.')
            ->line('Alternatively, you can copy and paste this link in your browser:')
            ->line($verificationUrl);
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
