<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getNotification(){
        $user = User::find(Auth::user()->id);
        $notifications = $user->notifications()
                        ->whereNull('read_at') // Only get unread notifications
                        ->get();

        return response()->json($notifications);
    }

    public function getNotificationCount(){
        $user = User::find(Auth::user()->id);
        $user->load('notifications');
        $notifications = count($user->notifications->where('read_at', null));

        return response()->json($notifications);
    }

    public function readNotif(Request $request){
        try{
            $notif = Notification::find($request->notif);
            $notif->update([
                'read_at'   => now()
            ]);
            $bool = 1;
        }catch(Exception $e){
            $bool = 0;
            Log::info($e->getMessage());
        }

        return $bool;
    }

    public function listNotif(){
        $user = Auth::user();
        $notifications = $user->notifications;

        return view('auth.listNotif', compact('user', 'notifications'));
    }
}
