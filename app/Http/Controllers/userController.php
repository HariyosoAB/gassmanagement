<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth,Redirect;
use App\User;
class userController extends Controller
{
    public function showlogin(){
      if(Auth::check()){
        if(Auth::user()->user_role == 1){
          return Redirect::to('/cust/create-order');
        }elseif(Auth::user()->user_role == 2){
          return Redirect::to('/occ/preview-order');
        }elseif(Auth::user()->user_role == 3){
          return view('pages/tes');
        }
      }
      else {
        return view('login');
      }
    }

    public function login(Request $request){
      if(Auth::attempt(['user_no_pegawai' => $request->id, 'password' => $request->password]))
      {
        // echo "logged in boi";
        //return Redirect::to('/adminhome');
        $data['nav'] = "order";

        if(Auth::user()->user_role == 1){
          return Redirect::to('/cust/create-order');
        }elseif(Auth::user()->user_role == 2){
          return Redirect::to('/occ/preview-order');
        }elseif(Auth::user()->user_role == 3){
          return view('pages/tes');
        }
      }
      else
      {
        return Redirect::to('/login')->with('failed','Password/User ID does not match any records');
      }
    }

    public function logout(Request $request){
        Auth::logout();
        return Redirect::to('/login');
    }

    public function register(Request $request){
        $user = new user;
        $user->user_nama= $request->name;
        $user->user_no_pegawai = $request->id;
        $user->user_unit = $request->unit;
        $user->user_subunit = $request->subunit;
        $user->user_telp = $request->number;
        $user->user_jabatan =$request->position;
        $user->user_email = $request->email;
        $user->password = bcrypt($request->password);
        $user->user_role = 1;
        $user->save();
        return Redirect::to('/login')->with('success','You have successfully created a new account');
    }

}
