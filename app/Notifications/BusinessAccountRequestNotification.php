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

    public $tries = 3;
    public $backoff = 60;
    protected $businessAccount;
    public $title;
    public $body;
    public $notificationData;

    public function __construct(BusinessAccount $businessAccount)
    {
        $this->businessAccount = $businessAccount;

        $this->title = __('notifications.new_business_account_title');

        $this->body = __('notifications.new_business_account_body', [
            'name' => $this->businessAccount->name,
            'user'    => $this->businessAccount->user->name
        ]);

        $this->notificationData = [
            'id'   => (string) $this->businessAccount->id,
            'type' => 'business_account_request',
            'url'  => route('business-accounts.show', $this->businessAccount->id),
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
