<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Redirect;
use Auth;
use DB;
use Carbon\Carbon;
class customerController extends Controller
{
    public function orderForm(){
        $data['nav'] = "order";
        return view('pages/customer/create-order', $data);
    }
    public function editForm($id){
      $data['nav'] = "order";
      $data['fields'] = Order::find($id);
      return view('pages/customer/edit-order',$data);
    }


    public function editOrder(Request $request,$id){
        $order = Order::find($id);
        if($order->order_status == 1){
          $order->order_equipment = $request->equipment;
          $order->order_start = $request->start;
          $order->order_from = $request->from;
          $order->order_to = $request->to;
          $order->order_unit = $request->unit;
          $order->order_ac_reg = $request->acreg;
          $order->order_ac_type = $request->actype;
          $order->order_maintenance_type = $request->maintenance;
          $order->order_urgency = $request->urgency;
          $order->order_airline = $request->airline;
          $order->order_address = $request->address;
          $order->order_note = $request->note;
          $order->save();
        }
        else {
          return Redirect('/cust/on-progress')->with('success','Unable to edit data. Order already in execution phase.');
        }
        return Redirect('/cust/on-progress')->with('success','You have created a new order');
    }

    public function insertOrder(Request $request){
        $order = new Order;
        $order->order_user = Auth::user()->user_id;
        $order->order_equipment = $request->equipment;
        $order->order_start = $request->start;
        $order->order_from = $request->from;
        $order->order_to = $request->to;
        $order->order_unit = $request->unit;
        $order->order_ac_reg = $request->acreg;
        $order->order_ac_type = $request->actype;
        $order->order_maintenance_type = $request->maintenance;
        $order->order_urgency = $request->urgency;
        $order->order_airline = $request->airline;
        $order->order_address = $request->address;
        $order->order_note = $request->note;
        $order->order_status = 1;
        $order->save();



        return Redirect('/cust/on-progress')->with('success','You have created a new order');
    }
    public function viewprogress()
    {
      $data['progress'] = DB::table('order_f')
        ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
        ->join('actype','order_f.order_ac_type','=','actype.actype_id')
        ->join('urgency','order_f.order_urgency','=','urgency.urgency_id')
        ->join('airline','airline.airline_id','=','order_f.order_airline')
        ->where('order_f.order_status','!=','3')
        ->where('order_f.order_user','=',Auth::user()->user_id)
        ->get();
      return view('pages.customer.progress',$data);
    }

    public function onprogressTable(){
        $data['nav'] = "history";
        $data['progress'] = DB::table('order_f')
          ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
          ->join('actype','order_f.order_ac_type','=','actype.actype_id')
          ->join('airline','airline.airline_id','=','order_f.order_airline')
          ->where('order_f.order_status','!=','3')
          ->where('order_f.order_status','!=','9')
          ->where('order_f.order_user','=',Auth::user()->user_id)
          ->get();
        return view('pages/customer/on-progress', $data);
    }

    public function cancel($id,Request $request){
      $order = Order::find($id);
      $order->order_status = 9;
      $order->order_cancellation = $request->reason;
      $order->save();

      return Redirect('cust/on-progress');
    }

    public function completedTable(){
        $data['nav'] = "history";
        $data['progress'] = DB::table('order_f')
          ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
          ->join('actype','order_f.order_ac_type','=','actype.actype_id')
          ->join('urgency','order_f.order_urgency','=','urgency.urgency_id')
          ->join('airline','airline.airline_id','=','order_f.order_airline')
          ->where('order_f.order_status','=','3')
          ->where('order_f.order_user','=',Auth::user()->user_id)
          ->get();
        return view('pages/customer/completed', $data);
    }
}
