<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function show(string $id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->firstOrFail();

        if ($notification->read_at === null) {
            $notification->markAsRead();
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
}
