<?php

namespace App\Notifications;

use App\Models\Thing;
use App\Models\ThingDescription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ThingDescriptionChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Thing $thing, public ThingDescription $description)
    {
    }

    public function via(object $notifiable): array
    {
        if ($notifiable->id === $this->thing->master_id) {
            return ['database', 'mail'];
        }

        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Описание вещи обновлено')
            ->line("Вещь: {$this->thing->name}")
            ->line('Описание обновлено. Проверьте актуальные детали.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'thing_description_changed',
            'title' => 'Описание изменено',
            'message' => "Вещь «{$this->thing->name}»",
            'thing_id' => $this->thing->id,
            'thing_name' => $this->thing->name,
            'description_id' => $this->description->id,
        ];
    }
}
