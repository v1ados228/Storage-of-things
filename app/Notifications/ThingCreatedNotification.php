<?php

namespace App\Notifications;

use App\Models\Thing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ThingCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Thing $thing)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Новое объявление')
            ->line("Добавлена вещь: {$this->thing->name}")
            ->line('Подробности доступны в приложении.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'thing_created',
            'title' => 'Новое объявление',
            'message' => "Добавлена вещь «{$this->thing->name}»",
            'thing_id' => $this->thing->id,
            'thing_name' => $this->thing->name,
        ];
    }
}
