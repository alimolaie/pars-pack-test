<?php

namespace App\Http\Controllers;

use App\Models\expiredSubscriptionDoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (Auth::guard('admin')->attempt($data)) {
            $token = Auth::guard('admin')->user()->createToken('PassportAuth')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
    function listExpiredStatus(){
        $recentSubscribes=expiredSubscriptionDoc::orderBy('created_at', 'desc')->get();
        foreach ($recentSubscribes as $subscribe){
            $app[]=$subscribe->sub->app->app_name;
        }

        if (Auth::guard('admin')->check()){
            return response()->
            json([
                'status' => 200,
                'recent subscribe App' => [$app]
            ], 200);
        }
        else
            return response()->json(['error' => 'Unauthorised'], 401);

    }
}
