<?php
namespace App\Helpers;

use App\Models\Notification;
use Auth;
use DB;
class Helper
{
    static function notificationCount()
    {
        $currenttime = \Carbon\Carbon::now();
        $last_notify= Auth::user()->last_notify;
        $notification_count=Notification::whereBetween('created_at', [$last_notify,$currenttime->toDateTimeString()])->count();
        return $notification_count==0?'':$notification_count;
    }

    static function notifications()
    {
        $last_notify= Auth::user()->last_notify;

       $notifications = DB::table('notifications')->select(['notification','created_at',DB::raw('(case when whereDate("created_at", ">",'.$last_notify.')
        then "1" else "0" end) as new')])->get();
return $notifications;
    }

}