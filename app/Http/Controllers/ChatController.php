<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;
use App\Events\ChatEvent;
use App\Events\PrivateMessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewPostNotify;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	return view('chat.chat');
    }

    public function fetchAllMessages(Request $request)
    {
        
        return Chat::with('user')
        ->where(function ($query) use ($request){
            $query->where('user_id','=',$request->user()->id)
                  ->where('user2_id','=',$request->user2_id);
        })->orWhere(function ($query) use ($request) {
            $query->where('user_id','=',$request->user2_id)
                  ->where('user2_id','=',$request->user()->id);
        })->get();


        
    }

    public function sendMessage(Request $request)
    {
    	
            $message=Chat::create([
                'user_id' => auth()->user()->id,
                'user2_id' => $request->user2_id,
                'message'=>$request->message,
            ]);
         
       
        $user = User::where('id',$request->user2_id)->select('name','email')->first();
       
        $post = Chat::with('user')->where('id',$message->id)->first();
        
        broadcast(new PrivateMessageSent($message->load('user')))->toOthers();


        Notification::route('mail' , $user->email) 
                          ->notify(new NewPostNotify($post));

        return response(['status'=>'Message private sent successfully','message'=>$message]);

    }

  
    
}