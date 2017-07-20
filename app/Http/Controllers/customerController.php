<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Redirect;

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
        $order->order_end = $request->End;
        $order->order_from = $request->from;
        $order->order_to = $request->to;
        $order->order_unit = $request->unit;
        $order->order_ac_reg = $request->ac-reg;
        $order->order_ac_type = $request->ac-type;
        $order->order_maintenance_type = $request->maintenance;
        $order->order_urgency = $request->urgency;
        $order->order_airline = $request->airline;
        $order->order_address = $request->address;
        $order->order_note = $request->note;
        $order->order_status = 1;
        $order->save();

        return Redirect('/cust/progress')->with('success','You have created a new order');

    }
}
