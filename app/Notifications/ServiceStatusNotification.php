<?php

namespace App\Notifications;

use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ServiceStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 60;
    protected Service $service;
    protected ?string $reason;


    public function __construct(Service $service, ?string $reason = null)
    {
        $this->service = $service;
        $this->reason = $reason;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    protected function getNotificationData(): array
    {
        $status = $this->service->status->value;

        $icon = match ($status) {
            'approved' => 'bx-check-circle',
            'rejected' => 'bx-x-circle',
            'inactive' => 'bx-minus-circle',
            default    => 'bx-info-circle'
        };

        return [
            'title_key' => "notifications.service_{$status}_title",
            'body_key'  => "notifications.service_{$status}_body",
            'body_args' => [
                'title' => $this->service->title,
            ],
            'icon' => $icon,
            'id'   => (string) $this->service->id,
            'type' => 'service_status_update',
            'url'  => route('services.show', $this->service->id),
        ];
    }

    // 1. save notification in database
    public function toDatabase(object $notifiable): array
    {
        $data = $this->getNotificationData();

        return [
            'title_key' => $data['title_key'],
            'body_key'  => $data['body_key'],
            'body_args' => $data['body_args'],
            'icon'      => $data['icon'],
            'data'      => [
                'id'     => $data['id'],
                'status' => $this->service->status->value,
                'type'   => $data['type'],
                'url'    => $data['url'],
                'reason' => $this->reason,
            ],
        ];
    }
}
