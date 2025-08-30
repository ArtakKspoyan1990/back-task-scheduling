<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return Notification::where('user_id', Auth::guard('api')->id())
            ->latest()
            ->paginate(10);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function markRead($id)
    {
        $notification = Notification::where('user_id', Auth::guard('api')->id())->findOrFail($id);
        $notification->update(['read' => true]);
        return response()->json($notification);
    }
}
