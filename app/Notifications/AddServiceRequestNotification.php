<?php

namespace App\Notifications;

use App\Channels\FcmChannel;
use App\Interfaces\FcmNotification;
use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as MessagingNotification;

class AddServiceRequestNotification extends Notification implements ShouldQueue, FcmNotification
{
    use Queueable;

    public $tries = 3;
    public $backoff = 60;
    protected $service;
    public $title;
    public $body;
    public $notificationData;

    public function __construct(Service $service)
    {
        $this->service = $service;

        $this->title = __('notifications.new_service_request_title');

        $this->body = __('notifications.new_service_request_body', [
            'title'    => $this->service->title,
            'business' => $this->service->businessAccount->name
        ]);

        $this->notificationData = [
            'id'   => (string) $this->service->id,
            'type' => 'service_request',
            'url'  => route('services.show', $this->service->id),
        ];
    }

    public function via(object $notifiable): array
    {
        return ['database', FcmChannel::class];
    }

    // 1. save notification in database
    public function toDatabase($notifiable): array
    {
        return [
            'title' => $this->title,
            'body'  => $this->body,
            'data'  => $this->notificationData,
        ];
    }

    // 2. send notification by firebase    
    public function toFcm($notifiable)
    {
        return CloudMessage::new()
            ->withNotification(MessagingNotification::create($this->title, $this->body))
            ->withData($this->notificationData);
    }
}
