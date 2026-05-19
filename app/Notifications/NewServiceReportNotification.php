<?php

namespace App\Notifications;

use App\Channels\FcmChannel;
use App\Interfaces\FcmNotification;
use App\Models\Report; // تأكد من اسم المودل الخاص بالبلاغات عندك
use App\Models\ServiceReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as MessagingNotification;

class NewServiceReportNotification extends Notification implements ShouldQueue, FcmNotification
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 60;
    protected ServiceReport $report;

    public function __construct(ServiceReport $report)
    {
        $this->report = $report;
    }

    public function via(object $notifiable): array
    {
        return ['database', FcmChannel::class];
    }

    protected function getNotificationData(): array
    {
        return [
            'title_key' => 'notifications.new_service_report_title',
            'body_key'  => 'notifications.new_service_report_body',
            'body_args' => [
                'service' => $this->report->service->title ?? 'Unknown',
                'user'    => $this->report->user->name ?? 'Unknown',
            ],
            'icon' => 'bx-error-circle',
            'id'   => (string) $this->report->id,
            'type' => 'new_service_report',
            'url'  => route('reports.index', $this->report->id),
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
                'service_id' => $this->report->service_id ?? null,
                'type'       => $data['type'],
                'url'        => $data['url'],
            ],
        ];
    }

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
