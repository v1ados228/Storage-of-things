<?php

namespace App\Notifications;

use App\Models\Thing;
use App\Models\ThingUse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ThingAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Thing $thing, public ThingUse $use)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Вам назначили вещь')
            ->line("Вещь: {$this->thing->name}")
            ->line("Количество: {$this->use->amount}")
            ->line('Подробности доступны в приложении.');
    }

    public function toArray(object $notifiable): array
    {
        $unit = $this->use->unit?->abbreviation ? " {$this->use->unit->abbreviation}" : '';

        return [
            'type' => 'thing_assigned',
            'title' => 'Назначена вещь',
            'message' => "Вещь «{$this->thing->name}», {$this->use->amount}{$unit}",
            'thing_id' => $this->thing->id,
            'thing_name' => $this->thing->name,
            'amount' => $this->use->amount,
        ];
    }
}
