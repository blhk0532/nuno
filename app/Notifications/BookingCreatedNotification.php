<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class BookingCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $bookingNumber,
        public ?string $serviceName,
        public int $bookingId
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Booking Created',
            'message' => "Booking #{$this->bookingNumber} has been created for ".($this->serviceName ?? 'Service'),
            'booking_id' => $this->bookingId,
            'type' => 'booking_created',
        ];
    }
}
