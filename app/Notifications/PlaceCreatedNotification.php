<?php

namespace App\Notifications;

use App\Models\Place;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PlaceCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Place $place)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Создано новое место хранения')
            ->line("Место: {$this->place->name}")
            ->line('Подробности доступны в приложении.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'place_created',
            'title' => 'Новое место хранения',
            'message' => "Добавлено место «{$this->place->name}»",
            'place_id' => $this->place->id,
            'place_name' => $this->place->name,
        ];
    }
}
