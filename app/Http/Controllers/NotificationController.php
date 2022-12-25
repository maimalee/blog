<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::query()
            ->where('receiver_id', Auth::user()['id'])
            ->orderByDesc('id')
            ->get();

        foreach ($notifications as $n){
           $n->update(['status' => 'view']);
        }
        return view('notifications.index', [
            'notification' => $notifications,
        ]);
    }

    public function read(Request $request): RedirectResponse
    {
        $notification = Notification::query()->find($request['id']);

        if (empty($notification)) {
            return redirect()->to('/notifications');
        }

        if ('pending' == $notification['status']) {
            $notification->update(['status' => 'read']);
        }

        return redirect()->to($notification['url']);
    }
}
