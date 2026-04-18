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

    public int $tries = 3;
    public int $backoff = 60;
    protected Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function via(object $notifiable): array
    {
        return ['database', FcmChannel::class];
    }

    
    protected function getNotificationData(): array
    {
        return [
            'title_key' => 'notifications.new_service_request_title',
            'body_key'  => 'notifications.new_service_request_body',
            'body_args' => [
                'title'    => $this->service->title,
                'business' => $this->service->businessAccount->name ?? 'Unknown',
            ],
            'icon' => 'bx-spreadsheet',
            'id'   => (string) $this->service->id,
            'type' => 'service_request',
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
                'id'   => $data['id'],
                'type' => $data['type'],
                'url'  => $data['url'],
            ],
        ];
    }

    // 2. send notification by firebase    
    public function toFcm($notifiable)
    {
        $data = $this->getNotificationData();
        
        // تحديد لغة المستخدم لتصل الرسالة مترجمة للهاتف
        $locale = $notifiable->locale ?? app()->getLocale();

        $title = __($data['title_key'], [], $locale);
        $body  = __($data['body_key'], $data['body_args'], $locale);

        return CloudMessage::new()
            ->withNotification(MessagingNotification::create($title, $body))
            ->withData([
                'title' => $title,
                'body'  => $body,
                'id'    => $data['id'],
                'type'  => $data['type'],
                'url'   => $data['url'],
                'icon'  => $data['icon']
            ]);
    }
}