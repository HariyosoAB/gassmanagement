<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\EquipmentTimeslot;

use Redirect;
use Auth;
use DB;
use Carbon\Carbon;
use App\Notification;
class customerController extends Controller
{
    public $data;
    protected $user;
    public function __construct()
    {
      $this->middleware(function ($request, $next) {
           $this->data['unread'] = Notification::where('notification_read',0)->where('notification_user',Auth::user()->user_id)->count();
           //$this->data['notif'] = Notification::where('notification_user',Auth::user()->user_id)->take(10)->get();
            return $next($request);
         });
    }
    public function orderForm(){
        $this->data['nav'] = "order";
        $this->data['maintenance'] = DB::table('maintenance')->get();
        $this->data['airline'] = DB::table('airline')->get();
        $this->data['units'] = DB::table('unit')->get();
        $this->data['actype'] = DB::table('actype')->get();
        $this->data['equipment'] = DB::table('equipment')->get();
        $this->data['station'] = DB::table('station')->get();
        $this->data['urgency'] = DB::table('urgency')->get();

        return view('pages/customer/create-order', $this->data);
    }

    public function detailForm($id){
      $this->data['nav'] = "history";
      // $this->data['fields'] = Order::find($id);
      $this->data['fields'] = DB::table('order_f')
      ->join("maintenance", "maintenance.maintenance_id", "=", "order_f.order_maintenance_type")
      ->join("airline", "airline.airline_id", "=", "order_f.order_airline")
      ->join("unit", "unit.unit_id", "=", "order_f.order_unit")
      ->join("actype", "actype.actype_id", "=", "order_f.order_ac_type")
      ->join("equipment", "equipment.equipment_id", "=", "order_f.order_equipment")
      ->join("station", "station.station_id", "=", "order_f.order_address")
      ->join("urgency", "urgency.urgency_id", "=", "order_f.order_urgency")
      ->where("order_f.order_id", "=", $id)
      ->get();
      // dd($this->data['fields']);
      // $this->data['maintenance'] = DB::table('maintenance')->get();
      // $this->data['airline'] = DB::table('airline')->get();
      // $this->data['units'] = DB::table('unit')->get();
      // $this->data['actype'] = DB::table('actype')->get();
      // $this->data['equipment'] = DB::table('equipment')->get();
      // $this->data['station'] = DB::table('station')->get();
      // $this->data['urgency'] = DB::table('urgency')->get();

      return view('pages/customer/detail-order',$this->data);
    }

    public function editForm($id){
      $this->data['nav'] = "order";
      $this->data['fields'] = Order::find($id);
      $this->data['maintenance'] = DB::table('maintenance')->get();
      $this->data['airline'] = DB::table('airline')->get();
      $this->data['units'] = DB::table('unit')->get();
      $this->data['actype'] = DB::table('actype')->get();
      $this->data['equipment'] = DB::table('equipment')->get();
      $this->data['station'] = DB::table('station')->get();
      $this->data['urgency'] = DB::table('urgency')->get();

      return view('pages/customer/edit-order',$this->data);
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
      $this->data['progress'] = DB::table('order_f')
        ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
        ->join('actype','order_f.order_ac_type','=','actype.actype_id')
        ->join('urgency','order_f.order_urgency','=','urgency.urgency_id')
        ->join('airline','airline.airline_id','=','order_f.order_airline')
        ->where('order_f.order_status','!=','3')
        ->where('order_f.order_user','=',Auth::user()->user_id)
        ->orderBy('order_f.order_id','desc')
        ->get();
      return view('pages.customer.progress',$this->data);
    }

    public function onprogressTable(){
        $this->data['nav'] = "history";
        $this->data['progress'] = DB::table('order_f')
          ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
          ->join('actype','order_f.order_ac_type','=','actype.actype_id')
          ->join('airline','airline.airline_id','=','order_f.order_airline')
          ->where('order_f.order_status','!=','3')
          ->where('order_f.order_status','!=','9')
          ->where('order_f.order_user','=',Auth::user()->user_id)
          ->orderBy('order_f.order_id','desc')
          ->get();
        return view('pages/customer/on-progress', $this->data);
    }

    public function cancel($id,Request $request){
      $order = Order::find($id);
      if($order->order_status == 5 || $order->order_status == 10)
      {
        if(isset($order->order_delayed_until)){
          $datestart = Carbon::parse($order->order_delayed_until);
          $dateend = Carbon::parse($order->order_delayed_end);
        }
        else {
          $datestart = Carbon::parse($order->order_start);
          $dateend = Carbon::parse($order->order_end);
        }
        $checkdate1 = Carbon::parse($datestart)->format('Y-m-d');
        $checkdate2 = Carbon::parse($dateend)->format('Y-m-d');
        $checkdate1 = Carbon::parse($checkdate1);
        $checkdate2 = Carbon::parse($checkdate2);
        $diffdays = $checkdate1->diffInDays($checkdate2);
        $iter = $checkdate1;


        $datestart = $datestart->format('H.i');
        $dsexplode = explode('.',$datestart);
        $datestart = (int) $dsexplode[0]*2 + (int) round((float) $dsexplode[1]/60);
        $datestart  = (int) $datestart;

        $dateend = $dateend->format('H.i');
        $deexplode = explode('.',$dateend);
        $dateend = (int) $deexplode[0]*2 + (int) round((float) $deexplode[1]/60);
        $dateend  = (int) $dateend;

        for($x=0;$x<=$diffdays;$x++){
          $timeslot = EquipmentTimeslot::where('et_equipment','=',$order->order_em)->where('et_date','=',$iter)->first();
          if($checkdate1->diffInDays($checkdate2) != 0){
            if($iter->diffInDays($checkdate1) == 0){
              $start = $datestart;
              $end = 47;
            }
            elseif($iter->diffInDays($checkdate2) == 0){
              $start = 0;
              $end = $dateend;
            }
            else {
              $start = 0;
              $end =47;
            }
          }
          else {
            $start = $datestart;
            $end = $dateend;
          }
          $updateslot = $timeslot->et_timeslot;
          for($i=$start;$i<=$end;$i++){
            $updateslot[$i] = 0;
            $ts= DB::table('equipment_timeslot')->where('et_id', '=',$timeslot->et_id)->update(['et_timeslot' => $updateslot]);
          }
          $iter = $iter->copy()->addDays(1);
        }
    }
      $order->order_status = 9;
      $order->order_cancellation = $request->reason;
      $order->save();
      return Redirect('cust/on-progress');
    }

    public function completedTable(){
        $this->data['nav'] = "history";
        $this->data['progress'] = DB::table('order_f')
          ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
          ->join('actype','order_f.order_ac_type','=','actype.actype_id')
          ->join('urgency','order_f.order_urgency','=','urgency.urgency_id')
          ->join('airline','airline.airline_id','=','order_f.order_airline')
          ->where('order_f.order_status','=','3')
          ->where('order_f.order_user','=',Auth::user()->user_id)
          ->orderBy('order_f.order_id','desc')
          ->get();
        return view('pages/customer/completed', $this->data);
    }
}
