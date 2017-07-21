<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Redirect;
use Auth;
use DB;
class customerController extends Controller
{
    public function orderForm(){
      return view('pages/customer/create-order');
    }

    public function insertOrder(Request $request){
        $order = new Order;
        $order->order_swo = $request->swo;
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

        return Redirect('/cust/progress')->with('success','You have created a new order');
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

}
