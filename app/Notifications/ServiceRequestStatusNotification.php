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
    protected string $action;

    public function __construct(ServiceRequest $serviceRequest, string $action = 'created')
    {
        $this->serviceRequest = $serviceRequest;
        $this->action = $action;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    protected function getNotificationData(): array
    {
        $serviceTitle = $this->serviceRequest->service->title ?? 'N/A';
        $userName = $this->serviceRequest->user->name ?? 'Guest';

        return match ($this->action) {
            'created' => [
                'title_key' => 'notifications.request_created_title',
                'body_key'  => 'notifications.request_created_body',
                'body_args' => ['user' => $userName, 'service' => $serviceTitle],
                'icon'      => 'bx-list-plus',
                'type'      => 'new_incoming_request',
            ],
            'updated' => [
                'title_key' => 'notifications.request_updated_title',
                'body_key'  => 'notifications.request_updated_body',
                'body_args' => ['user' => $userName, 'service' => $serviceTitle],
                'icon'      => 'bx-edit',
                'type'      => 'request_updated',
            ],
            'approved' => [
                'title_key' => 'notifications.request_approved_title',
                'body_key'  => 'notifications.request_approved_body',
                'body_args' => ['service' => $serviceTitle],
                'icon'      => 'bx-check-circle',
                'type'      => 'request_approved',
            ],
            'rejected' => [
                'title_key' => 'notifications.request_rejected_title',
                'body_key'  => 'notifications.request_rejected_body',
                'body_args' => ['service' => $serviceTitle],
                'icon'      => 'bx-x-circle',
                'type'      => 'request_rejected',
            ],
            'cancelled' => [
                'title_key' => 'notifications.request_cancelled_title',
                'body_key'  => 'notifications.request_cancelled_body',
                'body_args' => ['user' => $userName, 'service' => $serviceTitle],
                'icon'      => 'bx-minus-circle',
                'type'      => 'request_cancelled',
            ],
            default => throw new \InvalidArgumentException("Invalid notification action: {$this->action}"),
        };
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
                'id'         => (string) $this->serviceRequest->id,
                'service_id' => $this->serviceRequest->service_id,
                'user_id'    => $this->serviceRequest->user_id,
                'type'       => $data['type'],
                'url'        => route('service-requests.show', $this->serviceRequest->id),
            ],
        ];
    }
}
