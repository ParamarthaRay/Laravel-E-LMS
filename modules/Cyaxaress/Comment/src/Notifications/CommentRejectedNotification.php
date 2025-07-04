<?php

namespace Cyaxaress\Comment\Notifications;

use Cyaxaress\Comment\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class CommentRejectedNotification extends Notification
{
    use Queueable;

    public $comment;

    public function __construct(Comment $comment)
    {
        //
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        $channels[] = 'mail';
        $channels[] = 'database';
        if (! empty($notifiable->telegram)) {
            $channels[] = TelegramChannel::class;
        }

        return $channels;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toTelegram($notifiable)
    {
        if (! empty($notifiable->telegram)) {
            return TelegramMessage::create()
                ->to($notifiable->telegram)
                ->content('Your comment has been rejected.')
                ->button('View Course', $this->comment->commentable->path());
        }
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your comment has been rejected.',
            'url' => $this->comment->commentable->path(),
        ];
    }
}
