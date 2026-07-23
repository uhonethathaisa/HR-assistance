<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserRegisteredNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public User $registeredUser
    ) {}

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
            ->subject('New User Registration - ' . config('app.name'))
            ->greeting('Hello Admin,')
            ->line('A new user has registered on ' . config('app.name') . '.')
            ->line('**Name:** ' . $this->registeredUser->name)
            ->line('**Email:** ' . $this->registeredUser->email)
            ->line('**Registered:** ' . $this->registeredUser->created_at->format('M d, Y \a\t H:i'))
            ->action('Review User', url('/admin/users'))
            ->line('Please review and approve this user to grant them access to the platform.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_user_registered',
            'user_id' => $this->registeredUser->id,
            'user_name' => $this->registeredUser->name,
            'user_email' => $this->registeredUser->email,
            'message' => 'New user registered: ' . $this->registeredUser->name . ' (' . $this->registeredUser->email . ')',
            'action_url' => '/admin/users',
        ];
    }
}
