<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $notification) {}

    public function index(Request $request)
    {
        $user = auth('web')->user();

        if ($request->query('filter') === 'unread') {
            $notifications = $user->unreadNotifications()->paginate(10);
        } else {
            $notifications = $this->notification->getNotifications($user, 10);
        }

        return view('dashboard.notifications.index', compact('notifications'));
    }

    public function readAndRedirect(DatabaseNotification $notification)
    {
        $this->notification->markAsRead(auth('web')->user(), $notification);

        $redirectUrl = $notification->data['data']['url'] ?? $notification->data['url'] ?? null;

        if ($redirectUrl) {
            return redirect($redirectUrl);
        }

        return back()->with('success', 'تم قراءة الإشعار');
    }

    public function markAllAsRead()
    {
        $this->notification->markAllAsRead(auth('web')->user());

        return back()->with('success', 'تم تعيين الكل كمقروء');
    }

    public function destroy(DatabaseNotification $notification)
    {
        $this->notification->deleteNotification(auth('web')->user(), $notification);

        return back()->with('success', 'تم الحذف بنجاح');
    }
}
