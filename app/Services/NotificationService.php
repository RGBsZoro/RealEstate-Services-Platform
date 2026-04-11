<?php

namespace App\Services;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Notifications\DatabaseNotification;

class NotificationService
{
    public function getNotifications($user, $perPage = 15)
    {
        return $user->notifications()->latest()->paginate($perPage);
    }

    public function getUnreadNotifications($user)
    {
        return $user->unreadNotifications()->latest()->paginate(10);
    }

    public function markAsRead($user, DatabaseNotification $notification)
    {
        if ($user->id !== $notification->notifiable_id || get_class($user) !== $notification->notifiable_type)
            throw new AuthorizationException();

        $notification->markAsRead();
        return $notification;
    }

    public function markAllAsRead($user)
    {
        return $user->unreadNotifications->markAsRead();
    }

    public function deleteNotification($user, DatabaseNotification $notification)
    {
        if ($user->id !== $notification->notifiable_id || get_class($user) !== $notification->notifiable_type)
            throw new AuthorizationException();

        return $notification->delete();
    }
}
