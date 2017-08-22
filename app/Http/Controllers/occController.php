<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\ProblemTagging;
use App\OrderManpower;
use App\Notification;
use App\EquipmentTimeslot;
use DB;
use Auth;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;

class occController extends Controller
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

  public function detail($id){

    $this->data['nav'] = "preview";
    // $this->data['fields'] = Order::find($id);
    $this->data['fields'] = DB::table('order_f')
    ->join("maintenance", "maintenance.maintenance_id", "=", "order_f.order_maintenance_type")
    ->join("airline", "airline.airline_id", "=", "order_f.order_airline")
    ->join("unit", "unit.unit_id", "=", "order_f.order_unit")
    ->join("actype", "actype.actype_id", "=", "order_f.order_ac_type")
    ->join("equipment", "equipment.equipment_id", "=", "order_f.order_equipment")
    ->join("station", "station.station_id", "=", "order_f.order_address")
    ->join("urgency", "urgency.urgency_id", "=", "order_f.order_urgency")
    ->leftjoin("equipment_many", "equipment_many.em_id", "=", "order_f.order_em")
    ->where("order_f.order_id", "=", $id)
    ->get();

    $this->data['manpower'] = DB::table('order_manpower')
    ->join('manpower', 'manpower.manpower_id', '=', 'order_manpower.manpower_id')
    ->where('order_manpower.order_id', '=', $id)
    ->get();

    return view('pages/customer/detail-order',$this->data);

  }

  public function cancel($id,Request $request){
    $order = Order::find($id);
    if($order->order_status == 5 || $order->order_status == 10)
    {
      $skrg = 1;
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
    else {
      $skrg=0;
    }

    $order->order_status = 9;
    $order->order_cancellation = $request->reason;
    $order->save();
    $notif = new Notification;
    $notif->notification_user = $order->order_user;
    $notif->notification_text = 'Your Order with SWO Number: '.$order->order_swo.' is cancelled';
    $notif->notification_timestamp = Carbon::now('Asia/Jakarta');
    $notif->save();
    if($skrg == 1){
      return Redirect('occ/wait-exec');
    }
    else {
      return Redirect('occ/preview-order');
    }
  }

  public function checkLateExec(Order $order){
    $now = Carbon::now('Asia/Jakarta');
    $now = $now->toDateTimeString();

    $startTime = Carbon::parse($order->order_start);
    $execTime = Carbon::parse($now);
    $totalDuration = $execTime->diffInMinutes($startTime);
    if($execTime->gt($startTime) && $totalDuration > 15)
    {
      return false;
    }
    else {
      $order->order_status = 2;
      $order->order_execute_at = $now;
      $order->save();
      DB::table('equipment_many')->where('em_id','=',$order->order_em)->update(['em_status_on_service' => 1]);
      //DB::table('manpower')->where('manpower_id','=',$order->order_operator)->orWhere('manpower_id','=',$order->order_wingman)->orWhere('manpower_id','=',$order->order_wingman2)->orWhere('manpower_id','=',$order->order_wingman3)->update(['manpower_status' => 1]);
      DB::table('manpower')->whereIn('manpower_id',function($query) use ($order){
        $query->select('manpower_id')
        ->from('order_manpower')
        ->where('order_id','=',$order->order_id);
      })->update(['manpower_status' => 1]);
      return true;
    }
  }

  public function problemTag($id,Request $request){
    $order= Order::find($id);
    $now = Carbon::now('Asia/Jakarta');
    $now = $now->toDateTimeString();

    foreach($request->reason as $key => $value){
      $cek = ProblemTagging::where('order_id' , '=',$id)->get();
      if(isset($cek))
      {
        $new = true;
        foreach($cek as $ke =>$val){
          if($val->pt_root_cause == $value){
            $new= false;
          }
        }
      //  dd($new);
      }
      if ($new) {
        $pt = new ProblemTagging;
        $pt->order_id = $order->order_id;
        $pt->pt_root_cause = $value;
        $pt->save();
      }
    }
    if($request->type == 'execute'){
      $order->order_status = 2;
      $order->order_execute_at = $now;
      $order->save();

      DB::table('equipment_many')->where('em_id','=',$order->order_em)->update(['em_status_on_service' => 1]);
      DB::table('manpower')->whereIn('manpower_id',function($query) use ($order){
        $query->select('manpower_id')
        ->from('order_manpower')
        ->where('order_id','=',$order->order_id);
      })->update(['manpower_status' => 1]);
      $notif = new Notification;
      $notif->notification_user = $order->order_user;
      $notif->notification_text = 'Your Order with SWO Number: '.$order->order_swo.' is executed';
      $notif->notification_timestamp = Carbon::now('Asia/Jakarta');
      $notif->save();
      return Redirect('/occ/wait-exec');
    }
    else if ($request->type == 'finish'){
      $order->order_status = 3;
      $order->order_finished_at = $now;
      $order->save();
      DB::table('equipment_many')->where('em_id','=',$order->order_em)->update(['em_status_on_service' => 0]);
      DB::table('manpower')->whereIn('manpower_id',function($query) use ($order){
        $query->select('manpower_id')
        ->from('order_manpower')
        ->where('order_id','=',$order->order_id);
      })->update(['manpower_status' => 0]);
      $notif = new Notification;
      $notif->notification_user = $order->order_user;
      $notif->notification_text = 'Your Order with SWO Number: '.$order->order_swo.' is finished';
      $notif->notification_timestamp = Carbon::now('Asia/Jakarta');
      $notif->save();
      return Redirect('/occ/on-progress');
    }
  }

  public function finishOrder($id){
    $order = Order::find($id);
    $now = Carbon::now('Asia/Jakarta');
    $now = $now->toDateTimeString();
    if($order->order_status != 3)
    {
      $startTime = Carbon::parse($order->order_end);
      $execTime = Carbon::parse($now);
      $totalDuration = $execTime->diffInMinutes($startTime);

      //bug here
      if($execTime->gt($startTime) && $totalDuration > 15)
      {
        $this->data['order'] = $order;
        $this->data['time'] = Carbon::now('Asia/Jakarta');
        $this->data['problems'] = DB::table('root_cause')->where('rc_softdel',0)->get();
        $this->data['time'] = $this->data['time']->toDateTimeString();
        $this->data['delay'] = "finish";
        $this->data['nav'] = "history-occ";
        return view('pages.occ.problem-tagging',$this->data);
      }
      else
      {
        $order->order_status = 3;
        $order->order_finished_at = $now;
        $order->save();
        DB::table('equipment_many')->where('em_id','=',$order->order_em)->update(['em_status_on_service' => 0]);
        DB::table('manpower')->whereIn('manpower_id',function($query) use ($order){
          $query->select('manpower_id')
          ->from('order_manpower')
          ->where('order_id','=',$order->order_id);
        })->update(['manpower_status' => 0]);

        $notif = new Notification;
        $notif->notification_user = $order->order_user;
        $notif->notification_text = 'Order with SWO Number: '.$order->order_swo.' is finished';
        $notif->notification_timestamp = Carbon::now('Asia/Jakarta');
        $notif->save();
        return Redirect('/occ/on-progress');
      }
    }
    else {
      return Redirect('/occ/on-progress');
    }


  }

  public function executeOrder($id){
    $order= Order::find($id);
    if($order->order_status == 5 || $order->order_status == 10)
    {
      $equipment = DB::table('equipment_many')->where('em_id','=',$order->order_em)->get();
      $this->data['mantabrak'] = DB::table('order_f')
      ->join('order_manpower','order_f.order_id','=','order_manpower.order_id')
      ->join('manpower','order_manpower.manpower_id','=','manpower.manpower_id')
      ->where('manpower.manpower_status','=','1')
      ->where('order_f.order_status','=',2)
      ->whereIn('order_manpower.manpower_id',function($query) use ($order){
        $query->select('manpower_id')
        ->from('order_manpower')
        ->where('order_id','=',$order->order_id);
      })->get();
      //  dd($this->data['mantabrak']);
      //  dd($manpower);


      if($equipment[0]->em_status_on_service == 1){
        $this->data['eqtabrak'] = DB::table('order_f')
        ->join('equipment','equipment.equipment_id','=','order_f.order_equipment')
        ->join('equipment_many','equipment_many.em_id','=','order_f.order_em')
        ->where('order_f.order_status','=',2)
        ->where('order_f.order_em','=',$order->order_em)
        ->get();
      }

      if(empty($this->data['mantabrak'][0]) && $equipment[0]->em_status_on_service == 0){

        if ($this->checkLateExec($order)) {
          $notif = new Notification;
          $notif->notification_user = $order->order_user;
          $notif->notification_text = 'Your Order with SWO Number: '.$order->order_swo.' is executed';
          $notif->notification_timestamp = Carbon::now('Asia/Jakarta');
          $notif->save();
          return Redirect('/occ/wait-exec');
        }
        else {
          $this->data['order'] = $order;
          $this->data['time'] = Carbon::now('Asia/Jakarta');
          $this->data['problems'] = DB::table('root_cause')->where('rc_softdel',0)->get();
          $this->data['time'] = $this->data['time']->toDateTimeString();
          $this->data['delay'] = "execute";
          $this->data['nav'] = "history-occ";
          return view('pages.occ.problem-tagging',$this->data);
        }
      }
      else {
        $this->data['order'] = $order;
        $this->data['manpower'] = DB::table('manpower')->where('manpower_softdel',0)->get();
        $this->data['equipment'] = DB::table('equipment_many')->where('em_equipment','=',$order->order_equipment)->where('em_softdel',0)->get();
        $this->data['nav'] = "history-occ";
        //dd($this->data);
        return view('pages.occ.in-use',$this->data);
      }
    }
    return redirect('/occ/wait-exec');
  }

  public function delayOrder($id,Request $request)
  {
    $order = Order::find($id);

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

    $order->order_delayed_until = $request->delaystart;
    $order->order_delayed_end = $request->delayend;
    $this->changeAlloc($order,"delayed");
    $order->order_status = 10;

    // if(isset($request->optabrak))
    // {
    //   $pt = new ProblemTagging;
    //   $pt->order_id = $order->order_id;
    //   $pt->pt_root_cause = 2;
    //   $pt->save();
    // }
    // if(isset($request->wingtabrak))
    // {
    //   $pt = new ProblemTagging;
    //   $pt->order_id = $order->order_id;
    //   $pt->pt_root_cause = 3;
    //   $pt->save();
    // }
    //
    // if(isset($request->eqtabrak))
    // {
    //   $pt = new ProblemTagging;
    //   $pt->order_id = $order->order_id;
    //   $pt->pt_root_cause = 1;
    //   $pt->save();
    // }
    $order->save();
    $notif = new Notification;
    $notif->notification_user = $order->order_user;
    $notif->notification_text = 'Your Order with SWO Number: '.$order->order_swo.' is Delayed';
    $notif->notification_timestamp = Carbon::now('Asia/Jakarta');
    $notif->save();
    return redirect('/occ/wait-exec');
  }

  public function waitExec(){
    $this->data['nav'] = "history-occ";
    $this->data['orders'] = DB::table('order_f')
    ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
    ->join('equipment_many','equipment_many.em_id','=','order_f.order_em')
    ->join('actype','order_f.order_ac_type','=','actype.actype_id')
    ->join('airline','airline.airline_id','=','order_f.order_airline')
    ->join('maintenance','maintenance.maintenance_id','=','order_f.order_maintenance_type')
    ->join('urgency','urgency.urgency_id','order_f.order_urgency')
    ->where('order_f.order_status','=','5')
    ->orWhere('order_f.order_status','=','10')
    ->orderBy('order_id','desc')
    ->get();
    return view('pages/occ/wait-exec',$this->data);
  }
  public function previewOrder(){
    $this->data['nav'] = "preview";
    $this->data['orders'] = DB::table('order_f')
    ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
    ->join('actype','order_f.order_ac_type','=','actype.actype_id')
    ->join('airline','airline.airline_id','=','order_f.order_airline')
    ->join('maintenance','maintenance.maintenance_id','=','order_f.order_maintenance_type')
    ->where('order_f.order_status','=','1')
    ->orderBy('order_f.order_id','desc')
    ->get();
    return view('pages/occ/preview-order', $this->data);
  }

  public function onprogressTable(){
    $this->data['nav'] = "history-occ";
    $this->data['orders'] = DB::table('order_f')
    ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
    ->join('equipment_many','equipment_many.em_id','=','order_f.order_em')
    ->join('actype','order_f.order_ac_type','=','actype.actype_id')
    ->join('airline','airline.airline_id','=','order_f.order_airline')
    ->join('maintenance','maintenance.maintenance_id','=','order_f.order_maintenance_type')
    ->join('urgency','urgency.urgency_id','order_f.order_urgency')
    ->where('order_f.order_status','=','2')
    ->orderBy('order_id','desc')
    ->get();
    return view('pages/occ/on-progress', $this->data);
  }

  public function completedTable(){
    $this->data['nav'] = "history-occ";
    return view('pages/occ/completed', $this->data);
  }

  public function ajaxCompleted(){
    $cek = DB::table('order_f');
    $this->data['orders'] = DB::table('order_f')
    ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
    ->join('actype','order_f.order_ac_type','=','actype.actype_id')
    ->join('airline','airline.airline_id','=','order_f.order_airline')
    ->join('maintenance','maintenance.maintenance_id','=','order_f.order_maintenance_type')
    ->where('order_f.order_status','=','3')
    ->orderBy('order_id','desc')
    ->get();

    foreach($cek as $key){
      if($key->order_status == 3)
      {
        $datetime1 = strtotime($key->order_start);
        $datetime2 = strtotime($key->order_execute_at);
        $interval  = $datetime2 - $datetime1;
        $minutes   = round($interval / 60);
              //echo $minutes;

        $datetime1 = strtotime($key->order_end);
        $datetime2 = strtotime($key->order_finished_at);
        $interval  = $datetime2 - $datetime1;
        $minutes2   = round($interval / 60);
              //echo ".".$minutes2;



        if(isset($key->order_delayed_until) || $minutes > 15 || $minutes2 > 15){
          $key->order_status = "Completed - Delayed";
        }else{
          $key->order_status = "Completed - Ontime";
        }
      }
    }

    return Datatables::of($cek)->make(true);
  }

  public function canceledTable(){
    $this->data['nav'] = "history-occ";
    $this->data['orders'] = DB::table('order_f')
    ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
    ->join('actype','order_f.order_ac_type','=','actype.actype_id')
    ->join('airline','airline.airline_id','=','order_f.order_airline')
    ->join('maintenance','maintenance.maintenance_id','=','order_f.order_maintenance_type')
    ->where('order_f.order_status','=','9')
    ->orderBy('order_id','desc')
    ->get();
    return view('pages/occ/canceled', $this->data);
  }

  public function allTable(){
    $this->data['nav'] = "history-occ";
    return view('pages/occ/all-order', $this->data);
  }

  public function ajaxAllTable(){
    $cek = DB::table('order_f')
    ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
    ->join('actype','order_f.order_ac_type','=','actype.actype_id')
    ->join('airline','airline.airline_id','=','order_f.order_airline')
    ->join('maintenance','maintenance.maintenance_id','=','order_f.order_maintenance_type')
    ->orderBy('order_id','desc')
    ->get();

    foreach($cek as $key){
      if($key->order_status == 3)
      {
        $datetime1 = strtotime($key->order_start);
        $datetime2 = strtotime($key->order_execute_at);
        $interval  = $datetime2 - $datetime1;
        $minutes   = round($interval / 60);
              //echo $minutes;

        $datetime1 = strtotime($key->order_end);
        $datetime2 = strtotime($key->order_finished_at);
        $interval  = $datetime2 - $datetime1;
        $minutes2   = round($interval / 60);
              //echo ".".$minutes2;



        if(isset($key->order_delayed_until) || $minutes > 15 || $minutes2 > 15){
          $key->order_status = "Completed - Delayed";
        }else{
          $key->order_status = "Completed - Ontime";
        }
      }
    }

    return Datatables::of($cek)->make(true);
  }

  public function allocateForm($id){
    $this->data['nav'] = "preview";
    $this->data['orders'] = DB::table('order_f')
    ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
    ->join('actype','order_f.order_ac_type','=','actype.actype_id')
    ->join('airline','airline.airline_id','=','order_f.order_airline')
    ->join('unit','unit.unit_id','=','order_f.order_unit')
    ->join('urgency','order_f.order_urgency','=','urgency.urgency_id')
    ->join('maintenance','maintenance.maintenance_id','=','order_f.order_maintenance_type')
    ->where('order_f.order_id','=',$id)
    ->get();
    //   dd($this->data);
    if($this->data['orders'][0]->order_status ==1)
    {
      $this->data['urgency'] = DB::table('urgency')->get();
      $this->data['manpower'] = DB::table('manpower')->where('manpower_softdel',0)->orderBy('manpower_capability','desc')->get();
      $this->data['equipment'] = DB::table('equipment_many')->where('em_softdel',0)->where('em_equipment','=',$this->data['orders'][0]->order_equipment)->get();
      return view('pages/occ/review-form',$this->data);
    }
    else {
      return redirect('occ/preview-order');
    }
  }

  public function reallocateOrder($id,Request $request)
  {
    $order = Order::find($id);
    if($order->order_status != 9 || $order->order_status != 3)
    {
      if(isset($request->deletedman)){
        foreach($request->deletedman as $key => $value) {
          //  dd($value);
          $om = OrderManpower::find($value);
          $om->delete();
        }
        if(isset($request->operator))
        {
          $om= new OrderManpower;
          $om->order_id = $id;
          $om->manpower_id = $request->operator;
          $om->om_type ="operator";
          $om->save();
        }
        if(isset($request->wingman))
        {
          foreach($request->wingman as $key => $value) {
            $om = new OrderManpower;
            $om->order_id = $id;
            $om->manpower_id = $value;
            $om->om_type = "wingman";
            $om->save();
          }
        }
      }
      if(isset($request->equipment)){
        if(isset($order->order_delayed_until)){
          $datestart = Carbon::parse($order->order_delayed_until);
          $dateend = Carbon::parse($order->order_delayed_end);
          $delayed = true;
        }
        else {
          $datestart = Carbon::parse($order->order_start);
          $dateend = Carbon::parse($order->order_end);
          $delayed = false;
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

        $order->order_em = $request->equipment;
        if($delayed)
        {
          $this->changeAlloc($order,"delayed");
        }
        else {
          $this->changeAlloc($order,"allocation");
        }
      }

      if($this->checkLateExec($order))
      {
        return Redirect('occ/wait-exec');
      }
      else{
        $this->data['order'] = $order;
        $this->data['time'] = Carbon::now('Asia/Jakarta');
        $this->data['problems'] = DB::table('root_cause')->where('rc_softdel',0)->get();
        $this->data['time'] = $this->data['time']->toDateTimeString();
        $this->data['delay'] = "execute";
        $this->data['nav'] = "history-occ";
        return view('pages.occ.problem-tagging',$this->data);
      }
    }
    else {
      return Redirect('occ/wait-exec');
    }

  }
  public function allocateOrder($id,Request $request)
  {
    $order = Order::find($id);
    if($order->order_status ==1)
    {
      $order->order_status = 5;
      $manorder = new OrderManpower;
      $manorder->order_id = $order->order_id;
      $manorder->manpower_id = $request->operator;
      $manorder->om_type = "operator";
      $manorder->save();
      foreach($request->wingman as $key => $value){
        $wingorder = new OrderManpower;
        $wingorder->order_id = $order->order_id;
        $wingorder->manpower_id = $request->wingman[$key];
        $wingorder->om_type = "wingman";
        $wingorder->save();
      }
      $order->order_em = $request->alloceqp;

      if(isset($request->delaystart)){
        $order->order_delayed_until = $request->delaystart;
        $order->order_delayed_end = $request->delayend;
        $order->order_status = 10;
        $this->changeAlloc($order,"delayed");
        $notif = new Notification;
        $notif->notification_user = $order->order_user;
        $notif->notification_text = 'Your Order with SWO Number: '.$order->order_swo.' is delayed';
        $notif->notification_timestamp = Carbon::now('Asia/Jakarta');
        $notif->save();
      }
      else {
        $this->changeAlloc($order,"allocation");
        $notif = new Notification;
        $notif->notification_user = $order->order_user;
        $notif->notification_text = 'Your Order with SWO Number: '.$order->order_swo.' has been approved';
        $notif->notification_timestamp = Carbon::now('Asia/Jakarta');
        $notif->save();
      }
      $order->save();

    }
    return Redirect('occ/preview-order');
  }

  public function changeAlloc(Order $order,$stat){
    if($stat== "delayed")
    {
      $datestart = Carbon::parse($order->order_delayed_until);
      $dateend = Carbon::parse($order->order_delayed_end);
    }
    else {
      $datestart = Carbon::parse($order->order_start);
      $dateend = Carbon::parse($order->order_end);
    }

    $checkdate1 = Carbon::parse($datestart)->format('Y-m-d');
    $datestart = $datestart->format('H.i');
    $dsexplode = explode('.',$datestart);
    $datestart = (int) $dsexplode[0]*2 + (int) round((float) $dsexplode[1]/60);
    $datestart  = (int) $datestart;

    $checkdate2 = Carbon::parse($dateend)->format('Y-m-d');
    $dateend = $dateend->format('H.i');
    $deexplode = explode('.',$dateend);
    $dateend = (int) $deexplode[0]*2 + (int) round((float) $deexplode[1]/60);
    $dateend  = (int) $dateend;

    $checkdate1 = Carbon::parse($checkdate1);
    $checkdate2 = Carbon::parse($checkdate2);
    $diffdays = $checkdate1->diffInDays($checkdate2);
    $iter = $checkdate1;

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
      if(isset($timeslot)){
        $updateslot = $timeslot->et_timeslot;
        for($i=$start;$i<=$end;$i++){
          $updateslot[$i] = 1;
        }
        $ts= DB::table('equipment_timeslot')->where('et_id', '=',$timeslot->et_id)->update(['et_timeslot' => $updateslot]);
      }
      else {
        $ts = new EquipmentTimeslot;
        $ts->et_equipment = $order->order_em;
        $time= "000000000000000000000000000000000000000000000000";
        for($i=$start;$i<=$end;$i++){
          $time[$i] = 1;
        }
        $ts->et_timeslot = $time;
        $ts->et_date = $iter;
        $ts->save();
      }
      $iter = $iter->copy()->addDays(1);
    }
    return;
  }

  public function checkAllocation($id,$date){
    $data['equipment'] = DB::table('equipment')->get();
    $data['nav'] = 'alokasi-occ';
    $data['id'] = $id;
    $data['date'] = $date;
    //dd($data);
    return view('pages/occ/all-allocation',$data);
  }

  public function checkUsed($id,$date){
    $query ="SELECT * FROM order_f,equipment,equipment_many,actype,airline,maintenance,urgency
    WHERE equipment.equipment_id = order_f.order_equipment
    and equipment_many.em_id = order_f.order_em
    and actype.actype_id = order_f.order_ac_type
    and airline.airline_id = order_f.order_airline
    and maintenance.maintenance_id = order_f.order_maintenance_type
    and urgency.urgency_id = order_f.order_urgency and
    (DATE(order_delayed_until) = '".$date."' or ( DATE(order_start) = '".$date."' and order_delayed_until is NULL)) AND order_status != 1
    and order_em = ".$id."
    ORDER BY order_id DESC";
    $order = DB::select($query);
    $this->data['order'] = $order;
    $this->data['nav'] = 'alokasi-occ';
    $this->data['date']= $date;
    $this->data['eq'] = DB::table('equipment_many')->join('equipment','equipment_many.em_equipment','equipment.equipment_id')->where('equipment_many.em_id',$id)->first();
      //dd($order);
    return view('pages.occ.checkused',$this->data);
  }

  public function allocationajax($id,$date){
    $date = $date->format('Y-m-d');
    $this->data['date'] = $date;
    $query = "SELECT * FROM equipment e
    INNER JOIN equipment_many em on e.equipment_id = em.em_equipment
    LEFT JOIN (
      SELECT * FROM equipment_timeslot where et_date = '".$date."'
      ) t on t.et_equipment = em.em_id
WHERE e.equipment_id = ".$id." AND em.em_softdel = 0
";
$this->data['alloc'] = DB::select($query);
return view('pages/occ/allocatable',$this->data);
        //dd($this->data);
}

public function allocation(){
  $this->data['equipment'] = DB::table('equipment')->get();
  $this->data['nav'] = 'alokasi-occ';
        //dd($this->data);
  return view('pages/occ/all-allocation',$this->data);
}

public function modalproblem($id){
  $this->data['problem'] = ProblemTagging::distinct()->select('rc_name')->where('order_id',$id)->join('root_cause','problem_tagging.pt_root_cause','=','rc_id')->get();
        //  dd($this->data);
  $this->data['order'] = Order::find($id);
  return view('pages/occ/modal-problemtagging',$this->data);
}




      //CRUD STARTS HERE

      //CRUD AC
public function actable(){
  $this->data['datas'] = DB::table('actype')->where('actype_softdel',0)->orderBy('actype_id','desc')->get();
  $this->data['nav'] = "settings-occ";
  return view('pages/occ/tabel-ac',$this->data);
}

public function formAC($id){
  $this->data['nav'] = "settings-occ";
  $this->data['data'] = DB::table('actype')->where('actype_id',$id)->first();
  return view('pages/occ/modal-ac',$this->data);
}

public function insertAC(Request $request){
  try {
    DB::table('actype')->insert([
      ['actype_code' => $request->code, 'actype_description' => $request->description]
      ]);
  } catch (Exception $e) {
    return Redirect('occ/actable')->with('failed','Failed to save AC Type Data');
  }
  return Redirect('occ/actable')->with('success','AC Type Data saved successfully');
}

public function editAC($id,Request $request){
  try {
    DB::table('actype')->where('actype_id', '=',$id)->update(['actype_code' => $request->code, 'actype_description'=> $request->description]);
  } catch (Exception $e) {
    return Redirect('occ/actable')->with('failed','AC Type Data failed to update');
  }
  return Redirect('occ/actable')->with('success','AC Type Data edited successfully');
}

public function deleteAC($id){
  DB::table('actype')->where('actype_id', '=',$id)->update(['actype_softdel' => 1]);
  return Redirect('occ/actable')->with('success','AC Type Data Deleted Successfully');
        // try {
        //   DB::table('actype')->where('actype_id', '=',$id)->delete();
        // } catch (\Illuminate\Database\QueryException $e) {
        //   return Redirect('occ/actable')->with('failed','Unable to delete data, this data is used in an order');
        // } catch (PDOException $e) {
        //   return Redirect('occ/actable')->with('failed','Unable to delete data, this data is used in an order');
        // }
        //   return Redirect('occ/actable')->with('success','AC Type Data Deleted Successfully');
}

      //CRUD MANPOWER
public function manpowertable(){
  $this->data['datas'] = DB::table('manpower')->where('manpower_softdel',0)->orderBy('manpower_id','desc')->get();
  $this->data['nav'] = "settings-occ";
  return view('pages/occ/tabel-manpower',$this->data);
}

public function formManpower($id){
  $this->data['nav'] = "settings-occ";
  $this->data['data'] = DB::table('manpower')->where('manpower_id',$id)->first();
  return view('pages/occ/modal-manpower',$this->data);
}

public function insertManpower(Request $request){
  try {
    DB::table('manpower')->insert([
      ['manpower_nama' => $request->nama, 'manpower_no_pegawai' => $request->no_peg,'manpower_status' => 0 , 'manpower_capability'=> $request->capability]
      ]);
  } catch (Exception $e) {
    return Redirect('occ/mantable')->with('failed','Failed to save Manpower Data');
  }
  return Redirect('occ/mantable')->with('success','Manpower Data saved successfully');
}

public function editManpower($id,Request $request){
  try {
    DB::table('manpower')->where('manpower_id', '=',$id)->update(['manpower_nama' => $request->nama, 'manpower_no_pegawai' => $request->no_peg, 'manpower_capability'=> $request->capability]);
  } catch (Exception $e) {
    return Redirect('occ/mantable')->with('failed','Manpower Data failed to update');
  }
  return Redirect('occ/mantable')->with('success','Manpower Data edited successfully');
}

public function deleteManpower($id){
  DB::table('manpower')->where('manpower_id', '=',$id)->update(['manpower_softdel' => 1]);
  return Redirect('occ/mantable')->with('success','Manpower Data Deleted Successfully');
}

      //CRUD ROOTCAUSE
public function rootcausetable(){
  $this->data['datas'] = DB::table('root_cause')->where('rc_softdel',0)->orderBy('rc_id','desc')->get();
  $this->data['nav'] = "settings-occ";
  return view('pages/occ/tabel-rootcause',$this->data);
}

public function formRootCause($id){
  $this->data['nav'] = "settings-occ";
  $this->data['data'] = DB::table('root_cause')->where('rc_id',$id)->first();
  return view('pages/occ/modal-rootcause',$this->data);
}

public function insertRootCause(Request $request){
  try {
    DB::table('root_cause')->insert([
      ['rc_name' => $request->nama, 'rc_description' => $request->description,'rc_pemutihan' => $request->type ]
      ]);
  } catch (Exception $e) {
    return Redirect('occ/rootcausetable')->with('failed','Failed to save Root Cause Data');
  }
  return Redirect('occ/rootcausetable')->with('success','Root Cause Data saved successfully');
}

public function editRootCause($id,Request $request){
  try {
    DB::table('root_cause')->where('rc_id', '=',$id)->update(['rc_name' => $request->nama, 'rc_description' => $request->description,'rc_pemutihan' => $request->type ]);
  } catch (Exception $e) {
    return Redirect('occ/rootcausetable')->with('failed','Root Cause Data failed to update');
  }
  return Redirect('occ/rootcausetable')->with('success','Root Cause Data edited successfully');
}

public function deleteRootCause($id){
  DB::table('root_cause')->where('rc_id', '=',$id)->update(['rc_softdel' => 1]);
  return Redirect('occ/rootcausetable')->with('success','Root Cause Data Deleted Successfully');
}

      //CRUD AIRLINE
public function airlinetable(){
  $this->data['datas'] = DB::table('airline')->where('airline_softdel',0)->orderBy('airline_id','desc')->get();
  $this->data['nav'] = "settings-occ";
  return view('pages/occ/tabel-airline',$this->data);
}

public function formAirline($id){
  $this->data['nav'] = "settings-occ";
  $this->data['data'] = DB::table('airline')->where('airline_id',$id)->first();
  return view('pages/occ/modal-airline',$this->data);
}

public function insertAirline(Request $request){
  try {
    DB::table('airline')->insert([
      ['airline_type' => $request->nama, 'airline_description' => $request->description]
      ]);
  } catch (Exception $e) {
    return Redirect('occ/airlinetable')->with('failed','Failed to save Airline Data');
  }
  return Redirect('occ/airlinetable')->with('success','Airline Data saved successfully');
}

public function editAirline($id,Request $request){
  try {
    DB::table('airline')->where('airline_id', '=',$id)->update(['airline_type' => $request->nama, 'airline_description' => $request->description]);
  } catch (Exception $e) {
    return Redirect('occ/airlinetable')->with('failed','Airline Data failed to update');
  }
  return Redirect('occ/airlinetable')->with('success','Airline Data edited successfully');
}

public function deleteAirline($id){
  DB::table('airline')->where('airline_id', '=',$id)->update(['airline_softdel' => 1]);
  return Redirect('occ/airlinetable')->with('success','Airline Data Deleted Successfully');
}

      //CRUD EQUIPMENT
public function equipmenttable(){
  $this->data['datas'] = DB::table('equipment')->where('equipment_softdel',0)->orderBy('equipment_id','desc')->get();
  $this->data['nav'] = "settings-occ";
  return view('pages/occ/tabel-equipment',$this->data);
}

public function formEquipment($id){
  $this->data['nav'] = "settings-occ";
  $this->data['data'] = DB::table('equipment')->where('equipment_id',$id)->first();
  return view('pages/occ/modal-equipment',$this->data);
}

public function insertEquipment(Request $request){
  try {
    DB::table('equipment')->insert([
      ['equipment_lc' => $request->nama, 'equipment_description' => $request->description, 'equipment_model' => $request->model]
      ]);
  } catch (Exception $e) {
    return Redirect('occ/equipmenttable')->with('failed','Failed to save Equipment Data');
  }
  return Redirect('occ/equipmenttable')->with('success','Equipment Data saved successfully');
}

public function editEquipment($id,Request $request){
  try {
    DB::table('equipment')->where('equipment_id', '=',$id)->update(['equipment_lc' => $request->nama, 'equipment_description' => $request->description, 'equipment_model' => $request->model]);
  } catch (Exception $e) {
    return Redirect('occ/equipmenttable')->with('failed','Equipment Data failed to update');
  }
  return Redirect('occ/equipmenttable')->with('success','Equipment Data edited successfully');
}

public function deleteEquipment($id){
  DB::table('equipment')->where('equipment_id', '=',$id)->update(['equipment_softdel' => 1]);
  return Redirect('occ/equipmenttable')->with('success','Equipment Data Deleted Successfully');
}
public function addEquipment($id, Request $request){
  try {
    DB::table('equipment_many')->insert([
      ['em_no_inventory' => $request->inv, 'em_part_number' => $request->part, 'em_status_on_service' => 0 ,'em_servicable' => $request->servicable,'em_equipment' => $id]
      ]);
  } catch (Exception $e) {
    return Redirect('occ/equipmenttable')->with('failed','Failed to save Inventory Data');
  }
  return Redirect('occ/equipmenttable')->with('success','Inventory Data saved successfully');
}
public function manyEquipment($id){
  $dat= DB::table('equipment')->where('equipment_id',$id)->first();
  $this->data['model'] = $dat->equipment_model;
  $this->data['datas'] = DB::table('equipment_many')->where('em_softdel',0)->where('em_equipment',$id)->orderBy('em_id','desc')->get();
      //  dd($this->data);
  return view('pages/occ/tabel-many',$this->data);
}
public function formMany($id){
  $this->data['data']= DB::table('equipment_many')->where('em_id',$id)->first();
      //  dd($this->data);
  return view('pages/occ/modal-many',$this->data);
}
public function editMany($id,Request $request){
  try {
    DB::table('equipment_many')->where('em_id', '=',$id)->update(['em_no_inventory' => $request->inv, 'em_servicable' => $request->servicable, 'em_part_number' => $request->part]);
  } catch (Exception $e) {
    return Redirect('occ/equipmenttable')->with('failed','Inventory Data failed to update');
  }
  return Redirect('occ/equipmenttable')->with('success','Inventory Data edited successfully');
}
public function deleteMany($id){
  DB::table('equipment_many')->where('em_id', '=',$id)->update(['em_softdel' => 1]);
  return Redirect('occ/equipmenttable')->with('success','Inventory Data Deleted Successfully');
}


}
