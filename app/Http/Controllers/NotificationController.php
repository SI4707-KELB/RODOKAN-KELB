<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isAdmin = $user->role === 'admin';

        $unreadNotifications = $user->notifications()->whereNull('read_at')->latest()->get();
        $readNotifications = $user->notifications()->whereNotNull('read_at')->latest()->limit(50)->get();
        $notifications = $user->notifications()->latest()->paginate(20);

        $stats = $this->buildStats($unreadNotifications);

        if ($isAdmin) {
            return view('notifications.admin_index', compact(
                'notifications',
                'unreadNotifications',
                'readNotifications',
                'stats',
            ));
        }

        return view('notifications.user_index', compact(
            'notifications',
            'unreadNotifications',
            'readNotifications',
        ));
    }

    public function show(string $id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->firstOrFail();

        if ($notification->read_at === null) {
            $notification->markAsRead();
        }

        if (auth()->user()->role === 'admin' && isset($notification->data['category'])) {
            return redirect($notification->data['url'] ?? route('notifications.index'));
        }

        return view('notifications.user_show', compact('notification'));
    }

    public function markAsRead(string $id): JsonResponse|RedirectResponse
    {
        $notification = auth()->user()->notifications()->where('id', $id)->firstOrFail();
        $notification->markAsRead();

        if (request()->expectsJson()) {
            return response()->json(['status' => 'success']);
        }

        return back();
    }

    public function markAllAsRead(): JsonResponse|RedirectResponse
    {
        auth()->user()->unreadNotifications->markAsRead();

        if (request()->expectsJson()) {
            return response()->json(['status' => 'success']);
        }

        return back();
    }

    public function destroy(string $id): JsonResponse|RedirectResponse
    {
        $notification = auth()->user()->notifications()->where('id', $id)->firstOrFail();
        $notification->delete();

        if (request()->expectsJson()) {
            return response()->json(['status' => 'success']);
        }

        return back();
    }

    public function destroyAll(): JsonResponse|RedirectResponse
    {
        auth()->user()->notifications()->delete();

        if (request()->expectsJson()) {
            return response()->json(['status' => 'success']);
        }

        return back();
    }

    private function buildStats($unreadNotifications): array
    {
        $byCategory = fn (string $category) => $unreadNotifications
            ->filter(fn (DatabaseNotification $n) => ($n->data['category'] ?? '') === $category)
            ->count();

        return [
            'unread' => $unreadNotifications->count(),
            'darurat' => $byCategory('darurat'),
            'verifikasi' => $byCategory('verifikasi'),
            'instansi' => $byCategory('instansi'),
        ];
    }
}
