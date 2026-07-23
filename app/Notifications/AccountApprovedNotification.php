<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountApprovedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct() {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Account Has Been Approved - ' . config('app.name'))
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Great news! Your account on **' . config('app.name') . '** has been approved.')
            ->line('You can now log in and start using all the features:')
            ->line('- Optimize your CV with AI-powered suggestions')
            ->line('- Generate professional cover letters')
            ->line('- Track your work history')
            ->line('- Access career development tools')
            ->action('Log In Now', url('/login'))
            ->line('Welcome aboard, and we look forward to helping you advance your career!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'account_approved',
            'message' => 'Your account has been approved! You can now log in.',
            'action_url' => '/login',
        ];
    }
}
