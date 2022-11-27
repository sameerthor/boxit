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
        $last_notify = Auth::user()->last_notify;
        if (Auth::user()->hasRole('Admin')) {
            $notification_count = Notification::whereBetween('created_at', [$last_notify, $currenttime->toDateTimeString()])->orderBy('id','DESC')->count();
        } else {
            $notification_count = Notification::whereBetween('created_at', [$last_notify, $currenttime->toDateTimeString()])->where('foreman_id',Auth::user()->id)->orderBy('id','DESC')->count();
        }
        return $notification_count == 0 ? '' : $notification_count;
    }

    static function notifications()
    {
        $last_notify = Auth::user()->last_notify;
        if (Auth::user()->hasRole('Admin')) {
            $notifications = DB::table('notifications')->select(['notification', 'created_at', DB::raw('(case when "created_at" > "' . $last_notify . '"
            then "1" else "0" end) as new')])->orderBy('id','DESC')->get();
        } else {
            $notifications = DB::table('notifications')->select(['notification', 'created_at', DB::raw('(case when "created_at" > "' . $last_notify . '"
            then "1" else "0" end) as new')])->where('foreman_id',Auth::user()->id)->orderBy('id','DESC')->get();
        }
        return $notifications;
    }
}
