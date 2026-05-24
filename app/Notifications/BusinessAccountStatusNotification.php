<?php

namespace App\Notifications;

use App\Models\BusinessAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class BusinessAccountStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 60;
    protected BusinessAccount $businessAccount;
    protected ?string $reason;

    public function __construct(BusinessAccount $businessAccount, ?string $reason = null)
    {
        $this->businessAccount = $businessAccount;
        $this->reason = $reason;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    protected function getNotificationData(): array
    {
        $status = $this->businessAccount->status->value;

        return [
            'title_key' => "notifications.business_account_{$status}_title",
            'body_key'  => "notifications.business_account_{$status}_body",
            'body_args' => [
                'name' => $this->businessAccount->name,
            ],
            'icon' => $status === 'approved' ? 'bx-check-circle' : 'bx-x-circle',
            'id'   => (string) $this->businessAccount->id,
            'type' => 'business_status_update',
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
                'id'     => $data['id'],
                'status' => $this->businessAccount->status,
                'type'   => $data['type'],
                'url'    => $data['url'],
                'reason' => $this->reason,
            ],
        ];
    }
}
