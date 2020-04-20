<?php

namespace App\Http\Controllers;

use App\user;
use App\message;
use App\notification;
use App\Events\messageLeft;
use App\Events\updateStatus;
use Illuminate\Http\Request;
use App\Events\newUserRegisterd;
use Illuminate\Support\Facades\Auth;

class AppAuth extends Controller
{
    public function __construct(){

        return $this->middleware('auth');
    }

    public function Viewhome()
    {

        $users = user::where([['id'  , '!=',auth()->user()->id] , ['status' , 1]])->get();
      
        return view('home' ,\compact('users'));

    }
    public function logOut(){

        user::where('id' , Auth::user()->id)->update(['status' => 0]);

        event(new updateStatus(''));
        
        Auth::logout();

        return \redirect()->route('login');
    }
    public function chat(Request $request){

        $status = user::where('username' , $request->username)->select('status')->get();

        $user = user::where('username' , $request->username)->pluck('id');

        $channel_token =  auth()->user()->id + $user[0];

        $rec = $request->username;

        $reciever_id = $user[0];

        // $messages = message::where('chat_token' , $channel_token)->get();

        if($status[0]->status == 1){
            return view('chat' , \compact('channel_token' , 'rec' ,'reciever_id'));

        }else{

            return \redirect()->back()->with('error' , 'this user is currently offline please check back later');
            
        }
    }

    public function sendMessage(Request $request){
      
        // return $request->message;

        $token = $request->token;

        $msg = $request->message;

        $message = $msg != '' ? $msg :'no msg';

        $file = $request->file;

        $reciever = $token - auth()->user()->id;

        $Name = 'no photo';

        $extensions = ['jpg' , 'png' , 'jpeg' , 'gif' , 'pdf' , 'docx'];

         if($request->file != null){

             $file = $request->file;
    
             $imageExt = $file->getClientOriginalExtension();
    
             $imageSize = $file->getSize();

             $newName = time().'.'.$imageExt;

            //  check if it's a valid pic  

             if (!in_array($imageExt , $extensions)):

                 return redirect()->back()->with('extension' , 'extension of this file is not valid');    

             endif;

                // store data 
                $path = '';
             if($imageExt == 'pdf' || $imageExt == 'docx'):

                 $file->storeAs('public/uploads/documents' , $newName);
                 $path = '/storage/uploads/documents/';
             else:

                 $file->storeAs('public/uploads/images' , $newName);
                 $path = '/storage/uploads/images/';

             endif;

             $Name = $path.$newName;

         }

         event(new newUserRegisterd($token , $message , \auth()->user()->id , $Name));

             message::create([
                 'sender' => auth()->user()->id,
                 'reciever' => $reciever,
                 'body' => $message,
                 'photo' => $Name,
                 'chat_token' => $token
             ]);
        
             \event(new messageLeft(\auth()->user()->username , $reciever , auth()->user()->id));

        return 'success';
    }

    public function getActiveUsers(Request $request){

        $Auth_id = $request->id;

       $users = user::select('username' , 'id')->where([['id' , '!=' , $Auth_id] , ['status' , 1]])->get();

       return $users;

    }

    public function getChat(Request $request){
        
        $token = $request->token;

        $messages = message::where('chat_token' , $token)->get();

        return $messages;
    }

    public function getNotifications(Request $request){
        
        return notification::where('id' , $request->id)->get();

    }

    public function newNotification(Request $request){

        notification::create([
                'body' => $request->body,
                'seen' => false,
                'read' => false,
                'user_id' => $request->rec_id
        ]);

        return 'success';

    }

}
