<?php

namespace App\Notifications;

use App\Channels\FcmChannel;
use App\Interfaces\FcmNotification as InterfacesFcmNotification;
use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FcmNotification;

class ServiceRequestStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $tries = 3;
    protected $backoff = 60;
    protected $serviceRequest;
    private $title;
    private $body;

    public function __construct(ServiceRequest $serviceRequest)
    {
        $this->serviceRequest = $serviceRequest;
        $this->title = __('notifications.new_request_title');
        $this->body = __('notifications.new_request_body', [
            'service' => $this->serviceRequest->service->title,
            'user'    => $this->serviceRequest->user->name
        ]);
    }


    public function via($notifiable): array
    {
        return ['database'];
    }

    // save notification in database
    public function toDatabase($notifiable): array
    {
        return [
            'title' => $this->title,
            'body'  => $this->body,
            'data'  => [
                'id'         => $this->serviceRequest->id,
                'service_id' => $this->serviceRequest->service_id,
                'user_id'    => $this->serviceRequest->user_id,
                'type'       => 'new_incoming_request',
            ],
        ];
    }
}
