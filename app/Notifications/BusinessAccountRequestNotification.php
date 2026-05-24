<?php

namespace App\Notifications;

use App\Channels\FcmChannel;
use App\Interfaces\FcmNotification;
use App\Models\BusinessAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as MessagingNotification;

class BusinessAccountRequestNotification extends Notification implements ShouldQueue, FcmNotification
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 60;
    protected BusinessAccount $businessAccount;

    public function __construct(BusinessAccount $businessAccount)
    {
        $this->businessAccount = $businessAccount;
    }

    public function via(object $notifiable): array
    {
        return ['database', FcmChannel::class];
    }

    protected function getNotificationData(): array
    {
        return [
            'title_key' => 'notifications.new_business_account_title',
            'body_key'  => 'notifications.new_business_account_body',
            'body_args' => [
                'name' => $this->businessAccount->name,
                'user' => $this->businessAccount->user->name ?? 'Unknown',
            ],
            'icon' => 'bx-briefcase',
            'id'   => (string) $this->businessAccount->id,
            'type' => 'business_account_request',
            'url'  => route('business-accounts.show', $this->businessAccount->id),
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
