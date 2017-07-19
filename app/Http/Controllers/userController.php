<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth,Redirect;

class userController extends Controller
{
    public function showlogin(){
      return view('login');
    }

    public function login(Request $request){
      if(Auth::attempt(['user_no_pegawai' => $request->id, 'password' => $request->password]))
      {
        // echo "logged in boi";
        //return Redirect::to('/adminhome');
        if(Auth::user()->user_role == 1){
          return view('pages/tes');
        }elseif(Auth::user()->user_role == 2){
          return view('pages/tes');
        }elseif(Auth::user()->user_role == 3){
          return view('pages/tes');
        }
      }
      else
      {
        return Redirect::to('/login');
      }
    }

    public function logout(Request $request){
        Auth::logout();
        return Redirect::to('/login');
    }

}
