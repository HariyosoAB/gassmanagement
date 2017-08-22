<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth,Redirect;
use App\User;
use App\Notification;
use Hash;
class userController extends Controller
{
    public function showlogin(){
      if(Auth::check()){
        if(Auth::user()->user_role == 1){
          return Redirect::to('/cust/create-order');
        }elseif(Auth::user()->user_role == 2){
          return Redirect::to('/occ/preview-order');
        }elseif(Auth::user()->user_role == 3){
          return Redirect::to('/management/daily');
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
          return Redirect::to('/management/daily');
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
    public function formEditAccount($id){
    //  dd(Auth::user()->user_id);
    if(Auth::check()){
      if(Auth::user()->user_id == $id)
      {
      //  dd(session('failed'));
        $data['user'] = User::find($id);
        $data['nav'] = "";
        return view('pages.edit-profile',$data);
      }

    }
    return Redirect::to('/login');

    }
    public function editAccount($id,Request $request){
      $user = user::find($id);
      $user->user_nama= $request->name;
      $user->user_no_pegawai = $request->id;
      $user->user_unit = $request->unit;
      $user->user_subunit = $request->subunit;
      $user->user_telp = $request->number;
      if(isset($request->newpassword)){
        if(Hash::check($request->oldpassword, $user->password))
        {
                $user->password = bcrypt($request->newpassword);
        }
        else
        {
                return Redirect::to('/editaccount/'.$id)->with('failed','Old password does not match');
        }
      }
      $user->user_jabatan =$request->position;
      $user->user_email = $request->email;
      $user->save();
      return Redirect::to('/editaccount/'.$id)->with('success','Data updated successfully');

    }
    public function getNotif(){
      $data['notif'] = Notification::where('notification_user',Auth::user()->user_id)->where('notification_read',0)->take(10)->orderBy('notification_id','desc')->get();
      $data['many'] = Notification::where('notification_read',0)->where('notification_user',Auth::user()->user_id)->count();
      Notification::where('notification_user',Auth::user()->user_id)->where('notification_read',0)->update(['notification_read' => 1 ]);;
      return view('master.notif',$data);
    }

}
