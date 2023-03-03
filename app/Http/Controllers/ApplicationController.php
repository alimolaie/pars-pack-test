<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\expiredSubscriptionDoc;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminMail;
class ApplicationController extends Controller
{
    function checkStatusAndroidApp($id)
    {

        $subscriptionStatus = Subscription::whereHas('platform', function($q){
                $q->wherePlatform_os('android');
            })
            ->find($id);


        if ($subscriptionStatus){
            $status = $subscriptionStatus->subscription_status;

            $returnGoogle = match ($status) {
                'active'=> 'App name:'.$subscriptionStatus->app->app_name.' and user name: '.$subscriptionStatus->user->name.' status is active',
                'expired'=> 'App name:'.$subscriptionStatus->app->app_name.' and user name: '.$subscriptionStatus->user->name.' status is expired',
                'pending'=> 'App name:'.$subscriptionStatus->app->app_name.' and user name: '.$subscriptionStatus->user->name.' status is pending',
            };
            return response()->
            json([
                'status' => 200,
                'status Google' => $returnGoogle
            ], 200);
        }
     else{
         return response()->
         json([
             'status'=>404,
             'message' => "Application platform not android"
         ], 404);

        }

    }
    function checkStatusIOsApp($id)
    {
        $subscriptionStatus = Subscription::whereHas('platform', function($q){
            $q->wherePlatform_os('iOS');
        })
            ->find($id);


        if ($subscriptionStatus){
            $status = $subscriptionStatus->subscription_status;

            $returnAppStore = match ($status) {
                'active'=> 'App name:'.$subscriptionStatus->app->app_name.' and user name: '.$subscriptionStatus->user->name.' status is active',
                'expired'=> 'App name:'.$subscriptionStatus->app->app_name.' and user name: '.$subscriptionStatus->user->name.' status is expired',
                'pending'=> 'App name:'.$subscriptionStatus->app->app_name.' and user name: '.$subscriptionStatus->user->name.' status is pending',
            };
            return response()->
            json([
                'status' => 200,
                'status AppStore' => $returnAppStore
            ], 200);
        }
        else{
            return response()->
            json([
                'status' => 404,
                'message' => "Application platform not ios"
            ], 404);

        }

    }

    function changeStatusExpired($id)
    {
        $subscriptionStatus = Subscription::find($id);
        $subscriptionNotExist = Subscription::whereId($id)
            ->doesntExist();
        $admins=Admin::all();
        $emails=array();
        if ($subscriptionNotExist){
            return response()->
            json([
                'status' => 404,
                'message' => "The subscription not exist"
            ], 404);
        }
        if ($subscriptionStatus->subscription_status=="active"){
            $subscriptionStatus->subscription_status="expired";
            $subscriptionStatus->save();
            $doc= new expiredSubscriptionDoc();
            $doc->subscription_id = $subscriptionStatus->id;
            $doc->save();
            foreach ($admins as $admin){
                $emails[]=$admin->email;
            }
            Mail::to($emails)->send(new AdminMail($subscriptionStatus->app->app_name,$subscriptionStatus->platform->platform_os));
            return response()->
            json([
                'status' => 200,
                'message' => "success"
            ], 200);
        }
        else{
            return response()->
            json([
                'status' => 404,
                'message' => "The subscription not active"
            ], 404);
        }

    }
}
