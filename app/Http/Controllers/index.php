<?php

namespace App\Http\Controllers;

use App\user;
use App\Events\updateStatus;
use App\Events\userIsOnline;
use Illuminate\Http\Request;
use App\Events\newUserRegisterd;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class index extends Controller
{

    public function __construct(){

        return $this->middleware('guest');
    }

    public function login(Request $request){

        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt(['username' => $request->username , 'password' => $request->password])){

            user::where('id' , \auth()->user()->id)->update(['status' => 1]);
            
            event(new updateStatus(''));
            
            event(new userIsOnline(auth()->user()->username , auth()->user()->id));



            return redirect()->route('home');

        }

        return \redirect()->back()->with( 'error', 'username / password is incorrect');

    }

    public function register(){
        return view('register');
    }

    public function addUser(Request $request){
      $data =  $request->validate([
                'username' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);

          $user =  user::create([
              'username' => $data['username'],
              'password' => Hash::make($data['password']),
              'status' => '1'
          ]);

          user::where('id' , $user->id)->update(['status' =>  1]);

            Auth::loginUsingId($user->id);

            event(new updateStatus(''));

             return redirect()->route('home');
    }
}
