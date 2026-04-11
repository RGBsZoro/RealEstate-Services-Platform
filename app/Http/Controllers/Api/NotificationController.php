<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $notification) {}

    public function index()
    {
        $notifications = $this->notification->getNotifications(auth('api')->user());
        return successResponse(NotificationResource::collection($notifications));
    }

    public function getUnreadNotifications()
    {
        $unReadNotifications = $this->notification->getUnreadNotifications(auth('api')->user());
        return successResponse(NotificationResource::collection($unReadNotifications));
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        $notification = $this->notification->markAsRead(auth('api')->user(), $notification);
        return successResponse(NotificationResource::make($notification));
    }

    public function markAllAsRead()
    {
        $this->notification->markAllAsRead(auth('api')->user());
        return successResponse();
    }

    public function destroy(DatabaseNotification $notification)
    {
        $this->notification->deleteNotification(auth('api')->user(), $notification);
        return successResponse();
    }
}
