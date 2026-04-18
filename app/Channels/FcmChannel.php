<?php

namespace App\Channels;

use App\Interfaces\FcmNotification;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FcmChannel
{
  public function send($notifiable, Notification $notification)
  {

    if (!$notification instanceof FcmNotification) {
      return;
    }

    $message = $notification->toFcm($notifiable);

    $tokens = $notifiable->devices()->pluck('fcm_token')->toArray();

    if (empty($tokens)) {
      return;
    }

    $messaging = Firebase::messaging();

    try {

      $report = $messaging->sendMulticast($message, $tokens);

      $tokensToDelete = array_merge(
        $report->invalidTokens(),
        $report->unknownTokens()
      );

      if (!empty($tokensToDelete))
        $notifiable->devices()->whereIn('fcm_token', $tokensToDelete)->delete();
    } catch (\Exception $e) {

      Log::error('FCM Send Error: ' . $e->getMessage());
    }
  }
}