<?php

namespace App\Notifications;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ServiceRequestStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 60;
    protected ServiceRequest $serviceRequest;

    public function __construct(ServiceRequest $serviceRequest)
    {
        $this->serviceRequest = $serviceRequest;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    protected function getNotificationData(): array
    {
        return [
            'title_key' => 'notifications.new_request_title',
            'body_key'  => 'notifications.new_request_body',
            'body_args' => [
                'service' => $this->serviceRequest->service->title ?? 'N/A',
                'user'    => $this->serviceRequest->user->name ?? 'Guest',
            ],
            'icon' => 'bx-list-plus',
            'id'   => (string) $this->serviceRequest->id,
            'type' => 'new_incoming_request',
            'url'  => route('service-requests.show', $this->serviceRequest->id),
        ];
    }

    public function toDatabase(object $notifiable): array
    {
        $data = $this->getNotificationData();

        return [
            'title_key' => $data['title_key'],
            'body_key'  => $data['body_key'],
            'body_args' => $data['body_args'],
            'icon'      => $data['icon'],
            'data'      => [
                'id'         => $data['id'],
                'service_id' => $this->serviceRequest->service_id,
                'user_id'    => $this->serviceRequest->user_id,
                'type'       => $data['type'],
                'url'        => $data['url'],
            ],
        ];
    }
}