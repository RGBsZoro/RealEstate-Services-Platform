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

      Log::info('FCM TOKENS', $tokens);

      $report = $messaging->sendMulticast($message, $tokens);

      Log::info('FCM SUCCESS COUNT: ' . $report->successes()->count());

      Log::info('FCM FAILURE COUNT: ' . $report->failures()->count());

      foreach ($report->failures()->getItems() as $failure) {

        Log::error('FCM FAILURE', [
          'token' => $failure->target()->value(),
          'error' => $failure->error()->getMessage(),
        ]);
      }

      $tokensToDelete = array_merge(
        $report->invalidTokens(),
        $report->unknownTokens()
      );

      if (!empty($tokensToDelete)) {

        Log::warning('FCM TOKENS TO DELETE', $tokensToDelete);

        $notifiable->devices()
          ->whereIn('fcm_token', $tokensToDelete)
          ->delete();
      }
    } catch (\Exception $e) {

      Log::error('FCM Send Error: ' . $e->getMessage(), [
        'trace' => $e->getTraceAsString()
      ]);
    }
  }
}
