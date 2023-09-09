<?php

namespace App\Http\Controllers;

use App\Models\NotificationToken;
use Auth;
use Illuminate\Filesystem\Cache;
use Illuminate\Http\Request;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kutia\Larafirebase\Facades\Larafirebase;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\WebPushConfig;

class PushController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Store the PushSubscription.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $this->validate($request,[
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required'
        ]);
        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        $user = Auth::user();
        $user->updatePushSubscription($endpoint, $key, $token);

        return response()->json(['success' => true],200);
    }

    public function updateToken(Request $request){
        try{
            $check = ['token' => $request->token];
            $update = ['user_id' => $request->user()->id, 'token' => $request->token];
            NotificationToken::updateOrCreate($check, $update);
            $request->user()->update([ 'fcm_token' => $request->token, 'push_notify' => $request->push_notify]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }

    /**
     * @throws MessagingException
     * @throws FirebaseException
     */
    public function sendNotification(){
        //CloudMessage::withTarget()->withNotification(Notification::create('Hello', 'This is a test nofitifcation'))->withData('')

        $token = 'cdoaDfWFPuNL9lv6g5MUwT:APA91bF6Sp6yvmRXXLW27PvqDOXcdd8OOwQFH1EZl58rUU6YZrbi0kob8wswOI00AwnmHZrRD-UcFX099eYvfeXHswXLvzB4ZEnqYIxzj7QAP2bNAeZr0bD5XNPfyOgaCf8LnMWCVRUA';

        $message = CloudMessage::withTarget('token', $token)
            /*->withNotification($notification) // optional
            ->withData($data) // optional*/
        ;

        $messaging = app('firebase.messaging');
        return $messaging->send($message);
        //return $message;
        /*$message = CloudMessage::withTarget('topic', 'a-topic')
            ->withNotification(Notification::create('Title', 'Body'))
            ->withData(['key' => '117362381735']);
        $messaging = app('firebase.messaging');
        return $messaging->send($message);*/
        /*$messaging = app('firebase.messaging');
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(Notification::create('Test', 'Hello Peter Congratulations on this my friend you did it')) // optional
            //->withData($data) // optional
        ;
        return $messaging->send($message);*/
        $messaging = app('firebase.messaging');
        $deviceTokens = $token;
        /*$message = CloudMessage::new();
        $message->withChangedTarget('token', $token)->withNotification(Notification::create('Test', 'Hello Peter Congratulations on this my friend you did it'));*/
        return $messaging->send($message);
        $sendReport = $messaging->sendMulticast($message, [$deviceTokens]);
        return response()->json([
            'Successful' => $sendReport->successes()->count(),
            'Failed' => $sendReport->failures()->count()
        ]);
    }
}
