<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\EquipmentTimeslot;

use Redirect;
use Auth;
use DB;
use Carbon\Carbon;
class customerController extends Controller
{
    public function orderForm(){
        $data['nav'] = "order";
        $data['maintenance'] = DB::table('maintenance')->get();
        $data['airline'] = DB::table('airline')->get();
        $data['units'] = DB::table('unit')->get();
        $data['actype'] = DB::table('actype')->get();
        $data['equipment'] = DB::table('equipment')->get();
        $data['station'] = DB::table('station')->get();
        $data['urgency'] = DB::table('urgency')->get();


        return view('pages/customer/create-order', $data);
    }

    public function detailForm($id){
      $data['nav'] = "history";
      // $data['fields'] = Order::find($id);
      $data['fields'] = DB::table('order_f')
      ->join("maintenance", "maintenance.maintenance_id", "=", "order_f.order_maintenance_type")
      ->join("airline", "airline.airline_id", "=", "order_f.order_airline")
      ->join("unit", "unit.unit_id", "=", "order_f.order_unit")
      ->join("actype", "actype.actype_id", "=", "order_f.order_ac_type")
      ->join("equipment", "equipment.equipment_id", "=", "order_f.order_equipment")
      ->join("station", "station.station_id", "=", "order_f.order_address")
      ->join("urgency", "urgency.urgency_id", "=", "order_f.order_urgency")
      ->where("order_f.order_id", "=", $id)
      ->get();
      // dd($data['fields']);
      // $data['maintenance'] = DB::table('maintenance')->get();
      // $data['airline'] = DB::table('airline')->get();
      // $data['units'] = DB::table('unit')->get();
      // $data['actype'] = DB::table('actype')->get();
      // $data['equipment'] = DB::table('equipment')->get();
      // $data['station'] = DB::table('station')->get();
      // $data['urgency'] = DB::table('urgency')->get();

      return view('pages/customer/detail-order',$data);
    }

    public function editForm($id){
      $data['nav'] = "order";
      $data['fields'] = Order::find($id);
      $data['maintenance'] = DB::table('maintenance')->get();
      $data['airline'] = DB::table('airline')->get();
      $data['units'] = DB::table('unit')->get();
      $data['actype'] = DB::table('actype')->get();
      $data['equipment'] = DB::table('equipment')->get();
      $data['station'] = DB::table('station')->get();
      $data['urgency'] = DB::table('urgency')->get();

      return view('pages/customer/edit-order',$data);
    }


    public function editOrder(Request $request,$id){
        $order = Order::find($id);

        if($order->order_status == 1){
          $order->order_swo = $request->swo;
          $order->order_equipment = $request->equipment;
          $order->order_start = $request->start;
          $order->order_end = $request->end;
          $order->order_urgency = $request->urgency;
          if(null != $request->fromnew)
          {
            $order->order_from = $request->fromnew;

          }
          else {
            $order->order_from = $request->from;
          }
          if(null != $request->tonew)
          {
            $order->order_to = $request->tonew;

          }
          else {
            $order->order_to = $request->to;
          }
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
        $order->order_end = $request->end;
        $dt = Carbon::now();
        $order->order_ticket_number = substr(hash('md5', $dt),0,10);
        $order->order_swo = $request->swo;
        $order->order_urgency = $request->urgency;

        if(null != $request->fromnew)
        {
          $order->order_from = $request->fromnew;

        }
        else {
          $order->order_from = $request->from;
        }
        if(null != $request->tonew)
        {
          $order->order_to = $request->tonew;

        }
        else {
          $order->order_to = $request->to;
        }
        $order->order_unit = $request->unit;
        $order->order_ac_reg = $request->acreg;
        $order->order_ac_type = $request->actype;
        $order->order_maintenance_type = $request->maintenance;
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
        ->orderBy('order_f.order_id','desc')
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
          ->orderBy('order_f.order_id','desc')
          ->get();
        return view('pages/customer/on-progress', $data);
    }

    public function cancel($id,Request $request){
      $order = Order::find($id);
      if($order->order_status == 5)
      {
        if(isset($order->order_delayed_until)){
          $dels = Carbon::parse($order->order_delayed_until)->format('Y-m-d');
          $timeslotdel = EquipmentTimeslot::where('et_equipment','=',$order->order_em)->where('et_date','=',$dels)->first();

          $delaystart = Carbon::parse($order->order_delayed_until);
          $delaystart = $delaystart->format('H.i');
          $delsexplode = explode('.',$delaystart);
          $delaystart = (int) $delsexplode[0]*2 + (int) round((float) $delsexplode[1]/60);
          $delaystart  = (int) $delaystart;

          $delayend = Carbon::parse($order->order_delayed_end);
          $delayend = $delayend->format('H.i');
          $deleexplode = explode('.',$delayend);
          $delayend = (int) $deleexplode[0]*2 + (int) round((float) $deleexplode[1]/60);
          $delayend  = (int) $delayend;

          $updateslot = $timeslotdel->et_timeslot;
          for($i=$delaystart;$i<=$delayend;$i++){
             $updateslot[$i] = 0;
          }
        }
        else {
          $dels = Carbon::parse($order->order_start)->format('Y-m-d');
          $timeslotdel = EquipmentTimeslot::where('et_equipment','=',$order->order_em)->where('et_date','=',$dels)->first();

          $delaystart = Carbon::parse($order->order_start);
          $delaystart = $delaystart->format('H.i');
          $delsexplode = explode('.',$delaystart);
          $delaystart = (int) $delsexplode[0]*2 + (int) round((float) $delsexplode[1]/60);
          $delaystart  = (int) $delaystart;

          $delayend = Carbon::parse($order->order_end);
          $delayend = $delayend->format('H.i');
          $deleexplode = explode('.',$delayend);
          $delayend = (int) $deleexplode[0]*2 + (int) round((float) $deleexplode[1]/60);
          $delayend  = (int) $delayend;

          $updateslot = $timeslotdel->et_timeslot;
          for($i=$delaystart;$i<=$delayend;$i++){
             $updateslot[$i] = 0;
           }
          $ts= DB::table('equipment_timeslot')->where('et_id', '=',$timeslotdel->et_id)->update(['et_timeslot' => $updateslot]);
        }
    }
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
          ->orderBy('order_f.order_id','desc')
          ->get();
        return view('pages/customer/completed', $data);
    }
}
