<?php

namespace App\Notifications;

use App\Models\BusinessAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class BusinessAccountStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 3;
    public $backoff = 60;
    protected $businessAccount;
    public $title;
    public $body;

    public function __construct(BusinessAccount $businessAccount)
    {
        $this->businessAccount = $businessAccount;

        $status = $this->businessAccount->status->label();

        $this->title = __("notifications.business_account_{$status}_title");

        $this->body = __("notifications.business_account_{$status}_body", [
            'name' => $this->businessAccount->name,
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
                'id'     => $this->businessAccount->id,
                'status' => $this->businessAccount->status,
                'type'   => 'business_status_update',
            ],
        ];
    }
}
