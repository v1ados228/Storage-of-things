<?php

namespace App\Notifications;

use App\Models\Thing;
use App\Models\ThingUse;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ThingAssignedAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Thing $thing,
        public ThingUse $use,
        public User $assignee
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $unit = $this->use->unit?->abbreviation ? " {$this->use->unit->abbreviation}" : '';

        return (new MailMessage())
            ->subject('Назначена вещь пользователю')
            ->line("Вещь: {$this->thing->name}")
            ->line("Пользователь: {$this->assignee->name} ({$this->assignee->email})")
            ->line("Количество: {$this->use->amount}{$unit}");
    }
}
