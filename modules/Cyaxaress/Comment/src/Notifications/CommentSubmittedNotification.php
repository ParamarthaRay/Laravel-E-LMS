<?php

namespace Cyaxaress\Comment\Notifications;

use Cyaxaress\Comment\Mail\CommentSubmittedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kavenegar\LaravelNotification\KavenegarChannel;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class CommentSubmittedNotification extends Notification
{
    use Queueable;

    public $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable): array
    {
        $channels = [
            'mail',
            'database',
        ];
        if (! empty($notifiable->telegram)) {
            $channels[] = TelegramChannel::class;
        }
        if (! empty($notifiable->mobile)) {
            $channels[] = KavenegarChannel::class;
        }

        return $channels;
    }

    public function toMail($notifiable)
    {
        return (new CommentSubmittedMail($this->comment))->to($notifiable->email);
    }

    public function toTelegram($notifiable)
    {
        if (! empty($notifiable->telegram)) {
            return TelegramMessage::create()
                ->to($notifiable->telegram)
                ->content('A new comment has been submitted for your course on Raj_Hub.')
                ->button('View Course', $this->comment->commentable->path())
                ->button('Manage Comments', route('comments.index'));
        }
    }

    public function toSMS($notifiable)
    {
        return 'A new comment has been submitted for your course on Raj_Hub. Click the link below to view and respond.'."\n".route('comments.index');
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'A new comment has been submitted for your course.',
            'url' => route('comments.index'),
        ];
    }
}
