<?php

namespace App\Console;

use App\Models\Admin;
use App\Notifications\checkStatusNotif;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Subscription;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Broadcasting\Channel;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->call(function () {
            $subscriptionStatusAndroid = Subscription::whereHas('platform', function($q){
                $q->wherePlatform_os('android');
            })
                ->get();
            $subscriptionStatusAndroid->query()->update( [ 'subscription_status' => 'active'] );
            foreach ($subscriptionStatusAndroid as $android)
            {
                $statusAdnroid[]=$android->subscription_status;
            }
            $resultAndroid=response()->json([
                'status'=>200,
                'subscription android status'=>[$statusAdnroid]
            ],200);
            $admins=Admin::all();
            foreach ($admins as $admin){
                $emails[]=$admin->email;
            }
            Notification::send($emails,new checkStatusNotif($resultAndroid));
        })->weekly();
        $schedule->call(function () {
            $subscriptionStatusIOS = Subscription::whereHas('platform', function($q){
                $q->wherePlatform_os('iOS');
            })
                ->get();

            $subscriptionStatusIOS->query()->update( [ 'subscription_status' => 'expired'] );
            foreach ($subscriptionStatusIOS as $ios)
            {
                $statusIOS[]=$ios->subscription_status;
            }
            $resultIOS=response()->json([
                'status'=>200,
                'subscription ios status'=>[$statusIOS]
            ],200);
            $admins=Admin::all();
            foreach ($admins as $admin){
                $emails[]=$admin->email;
            }
            Notification::send($emails,new checkStatusNotif($resultIOS));
        })->weekly();
        if (!Http::response('ok')){
            $schedule->call(function () {
                $subscriptionStatusAndroid = Subscription::whereHas('platform', function($q){
                    $q->wherePlatform_os('android');
                })
                    ->get();
                foreach ($subscriptionStatusAndroid as $android)
                {
                    $statusAdnroid[]=$android->subscription_status;
                }
                $admins=Admin::all();
                foreach ($admins as $admin){
                    $emails[]=$admin->email;
                }
                Notification::route('mail', $emails)->send(new checkStatusNotif("check after 1 hours in android paltform".$statusAdnroid));
            })->hourlyAt(1);
        }
        if (!Http::response('ok')){
            $schedule->call(function () {
                $subscriptionStatusIOS = Subscription::whereHas('platform', function($q){
                    $q->wherePlatform_os('iOS');
                })
                    ->get();
                foreach ($subscriptionStatusIOS as $ios)
                {
                    $statusIOS[]=$ios->subscription_status;
                }
                $admins=Admin::all();
                foreach ($admins as $admin){
                    $emails[]=$admin->email;
                }
                Notification::route('mail', $emails)->send(new checkStatusNotif("check after 2 hours in ios paltform".$statusIOS));
            })->hourlyAt(2);

        }
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
