<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\ProblemTagging;
use App\OrderManpower;
use App\EquipmentTimeslot;
use DB;
use Carbon\Carbon;
class occController extends Controller
{

  public function cancel($id,Request $request){
    $order = Order::find($id);
    if($order->order_status == 5)
    {
      $skrg = 1;
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
    else {
      $skrg=0;
    }

    $order->order_status = 9;
    $order->order_cancellation = $request->reason;
    $order->save();
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
          $pt = new ProblemTagging;
          $pt->order_id = $order->order_id;
          $pt->pt_root_cause = $value;
          $pt->save();
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
          return Redirect('/occ/on-progress');
        }
    }

    public function finishOrder($id){
      $order = Order::find($id);
      $now = Carbon::now('Asia/Jakarta');
      $now = $now->toDateTimeString();


      $startTime = Carbon::parse($order->order_end);
      $execTime = Carbon::parse($now);
      $totalDuration = $execTime->diffInMinutes($startTime);

//bug here
      if($execTime->gt($startTime) && $totalDuration > 15)
      {
        $data['order'] = $order;
        $data['time'] = Carbon::now('Asia/Jakarta');
        $data['problems'] = DB::table('root_cause')->get();
        $data['time'] = $data['time']->toDateTimeString();
        $data['delay'] = "finish";
        $data['nav'] = "history-occ";
        return view('pages.occ.problem-tagging',$data);
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
        return Redirect('/occ/on-progress');
      }

    }

    public function executeOrder($id){
      $order= Order::find($id);
      if($order->order_status == 5 || $order->order_status == 10)
      {
        $equipment = DB::table('equipment_many')->where('em_id','=',$order->order_em)->get();
        $data['mantabrak'] = DB::table('order_f')
        ->join('order_manpower','order_f.order_id','=','order_manpower.order_id')
        ->join('manpower','order_manpower.manpower_id','=','manpower.manpower_id')
        ->where('manpower.manpower_status','=','1')
        ->where('order_f.order_status','=',2)
        ->whereIn('order_manpower.manpower_id',function($query) use ($order){
          $query->select('manpower_id')
          ->from('order_manpower')
          ->where('order_id','=',$order->order_id);
        })->get();
      //  dd($data['mantabrak']);
      //  dd($manpower);


        if($equipment[0]->em_status_on_service == 1){
          $data['eqtabrak'] = DB::table('order_f')
          ->join('equipment','equipment.equipment_id','=','order_f.order_equipment')
          ->join('equipment_many','equipment_many.em_id','=','order_f.order_em')
          ->where('order_f.order_status','=',2)
          ->where('order_f.order_em','=',$order->order_em)
          ->get();
        }

        if(empty($data['mantabrak'][0]) && $equipment[0]->em_status_on_service == 0){

          if ($this->checkLateExec($order)) {
              return Redirect('/occ/wait-exec');
          }
          else {
              $data['order'] = $order;
              $data['time'] = Carbon::now('Asia/Jakarta');
              $data['problems'] = DB::table('root_cause')->get();
              $data['time'] = $data['time']->toDateTimeString();
              $data['delay'] = "execute";
              $data['nav'] = "history-occ";
             return view('pages.occ.problem-tagging',$data);
          }
        }
        else {
          $data['order'] = $order;
          $data['manpower'] = DB::table('manpower')->where('manpower_status','=',0)->get();
          $data['equipment'] = DB::table('equipment_many')->where('em_equipment','=',$order->order_equipment)->where('em_status_on_service','=',0)->get();
          $data['nav'] = "history-occ";
          return view('pages.occ.in-use',$data);
        }
      }
      return redirect('/occ/wait-exec');
    }

    public function delayOrder($id,Request $request)
    {
      $order = Order::find($id);

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
        $ts= DB::table('equipment_timeslot')->where('et_id', '=',$timeslotdel->et_id)->update(['et_timeslot' => $updateslot]);
      }
      $order->order_delayed_until = $request->delaystart;
      $order->order_delayed_end = $request->delayend;
      $this->changeAlloc($order,"delayed");
      $order->order_status = 10;

      if(isset($request->optabrak))
      {
        $pt = new ProblemTagging;
        $pt->order_id = $order->order_id;
        $pt->pt_root_cause = 2;
        $pt->save();
      }
      if(isset($request->wingtabrak))
      {
        $pt = new ProblemTagging;
        $pt->order_id = $order->order_id;
        $pt->pt_root_cause = 3;
        $pt->save();
      }

      if(isset($request->eqtabrak))
      {
        $pt = new ProblemTagging;
        $pt->order_id = $order->order_id;
        $pt->pt_root_cause = 1;
        $pt->save();
      }
      $order->save();
      return redirect('/occ/wait-exec');
    }

    public function waitExec(){
      $data['nav'] = "history-occ";
      $data['orders'] = DB::table('order_f')
        ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
        ->join('equipment_many','equipment_many.em_id','=','order_f.order_em')
        ->join('actype','order_f.order_ac_type','=','actype.actype_id')
        ->join('airline','airline.airline_id','=','order_f.order_airline')
        ->join('maintenance','maintenance.maintenance_id','=','order_f.order_maintenance_type')
        ->join('urgency','urgency.urgency_id','order_f.order_urgency')
        ->where('order_f.order_status','=','5')
        ->orWhere('order_f.order_status','=','10')
        ->get();
      return view('pages/occ/wait-exec',$data);
    }
    public function previewOrder(){
        $data['nav'] = "preview";
        $data['orders'] = DB::table('order_f')
          ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
          ->join('actype','order_f.order_ac_type','=','actype.actype_id')
          ->join('airline','airline.airline_id','=','order_f.order_airline')
          ->join('maintenance','maintenance.maintenance_id','=','order_f.order_maintenance_type')
          ->where('order_f.order_status','=','1')
          ->orderBy('order_f.order_id','desc')
          ->get();
        return view('pages/occ/preview-order', $data);
    }

    public function onprogressTable(){
      $data['nav'] = "history-occ";
      $data['orders'] = DB::table('order_f')
        ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
        ->join('equipment_many','equipment_many.em_id','=','order_f.order_em')
        ->join('actype','order_f.order_ac_type','=','actype.actype_id')
        ->join('airline','airline.airline_id','=','order_f.order_airline')
        ->join('maintenance','maintenance.maintenance_id','=','order_f.order_maintenance_type')
        ->join('urgency','urgency.urgency_id','order_f.order_urgency')
        ->where('order_f.order_status','=','2')
        ->get();
        return view('pages/occ/on-progress', $data);
    }

    public function completedTable(){
      $data['nav'] = "history-occ";
      $data['orders'] = DB::table('order_f')
        ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
        ->join('equipment_many','equipment_many.em_id','=','order_f.order_em')
        ->join('actype','order_f.order_ac_type','=','actype.actype_id')
        ->join('airline','airline.airline_id','=','order_f.order_airline')
        ->join('maintenance','maintenance.maintenance_id','=','order_f.order_maintenance_type')
        ->join('urgency','urgency.urgency_id','order_f.order_urgency')
        ->where('order_f.order_status','=','3')
        ->get();
        return view('pages/occ/completed', $data);
    }

    public function canceledTable(){
      $data['nav'] = "history-occ";
      $data['orders'] = DB::table('order_f')
        ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
        ->join('actype','order_f.order_ac_type','=','actype.actype_id')
        ->join('airline','airline.airline_id','=','order_f.order_airline')
        ->join('maintenance','maintenance.maintenance_id','=','order_f.order_maintenance_type')
        ->where('order_f.order_status','=','9')
        ->get();
        return view('pages/occ/canceled', $data);
    }

    public function allTable(){
      $data['nav'] = "history-occ";
      $data['orders'] = DB::table('order_f')
        ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
        ->join('actype','order_f.order_ac_type','=','actype.actype_id')
        ->join('airline','airline.airline_id','=','order_f.order_airline')
        ->join('maintenance','maintenance.maintenance_id','=','order_f.order_maintenance_type')
        ->get();
      return view('pages/occ/all-order', $data);
    }

    public function allocateForm($id){
       $data['nav'] = "preview";
       $data['orders'] = DB::table('order_f')
         ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
         ->join('actype','order_f.order_ac_type','=','actype.actype_id')
         ->join('airline','airline.airline_id','=','order_f.order_airline')
         ->join('unit','unit.unit_id','=','order_f.order_unit')
         ->join('maintenance','maintenance.maintenance_id','=','order_f.order_maintenance_type')
         ->where('order_f.order_id','=',$id)
         ->get();
      //   dd($data);
       if($data['orders'][0]->order_status ==1)
       {
         $data['urgency'] = DB::table('urgency')->get();
         $data['manpower'] = DB::table('manpower')->orderBy('manpower_capability','desc')->get();
         $data['equipment'] = DB::table('equipment_many')->where('em_equipment','=',$data['orders'][0]->order_equipment)->get();
         return view('pages/occ/review-form',$data);
       }
       else {
         return redirect('occ/preview-order');
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
        //  $manorder->save();
          foreach($request->wingman as $key => $value){
                  $wingorder = new OrderManpower;
                  $wingorder->order_id = $order->order_id;
                  $wingorder->manpower_id = $request->wingman[$key];
                  $wingorder->om_type = "wingman";
        //          $wingorder->save();
          }
          $order->order_em = $request->alloceqp;

          if(isset($request->delaystart)){
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
              $ts= DB::table('equipment_timeslot')->where('et_id', '=',$timeslot->et_id)->update(['et_timeslot' => $updateslot]);
            }
            $order->order_delayed_until = $request->delaystart;
            $order->order_delayed_end = $request->delayend;
            $order->order_status = 10;
            $this->changeAlloc($order,"delayed");
          }
          else {
            $this->changeAlloc($order,"allocation");
          }
          //$order->save();

        }
        return Redirect('occ/preview-order');
    }

    public function changeAlloc(Order $order,$stat){
      $ds = Carbon::parse($order->order_start)->format('Y-m-d');
      $timeslot = EquipmentTimeslot::where('et_equipment','=',$order->order_em)->where('et_date','=',$ds)->first();

      $datestart = Carbon::parse($order->order_start);
      $checkdate1 = $datestart;
      $datestart = $datestart->format('H.i');
      $dsexplode = explode('.',$datestart);
      $datestart = (int) $dsexplode[0]*2 + (int) round((float) $dsexplode[1]/60);
      $datestart  = (int) $datestart;

      $dateend = Carbon::parse($order->order_end);
      $checkdate2 = $dateend;
      $dateend = $dateend->format('H.i');
      $deexplode = explode('.',$dateend);
      $dateend = (int) $deexplode[0]*2 + (int) round((float) $deexplode[1]/60);
      $dateend  = (int) $dateend;



      if($stat== "delayed")
      {
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

        if(isset($timeslot)){
          $updateslot = $timeslot->et_timeslot;
          for($i=$datestart;$i<=$dateend;$i++){
             $updateslot[$i] = 0;
             $ts= DB::table('equipment_timeslot')->where('et_id', '=',$timeslot->et_id)->update(['et_timeslot' => $updateslot]);
          }
        }

        if(isset($timeslotdel)){
          $updatedelslot = $timeslotdel->et_timeslot;
          for($i=$delaystart;$i<=$delayend;$i++){
             $updateslot[$i] = 1;
          }
          $ts= DB::table('equipment_timeslot')->where('et_id', '=',$timeslotdel->et_id)->update(['et_timeslot' => $updateslot]);
        }
        else {
          $ts = new EquipmentTimeslot;
          $ts->et_equipment = $order->order_em;
          $time= "000000000000000000000000000000000000000000000000";
          for($i=$delaystart;$i<=$delayend;$i++){
             $time[$i] = 1;
          }
          $ts->et_timeslot = $time;
          $ts->et_date = $dels;
          $ts->save();
        }
      }
      else {
        if($checkdate1 != $checkdate2){
          $bedate = 1;
        }
        if(isset($timeslot)){
          $updateslot = $timeslot->et_timeslot;
          for($i=$datestart;$i<=$dateend;$i++){
             $updateslot[$i] = 1;
          }
          $ts= DB::table('equipment_timeslot')->where('et_id', '=',$timeslot->et_id)->update(['et_timeslot' => $updateslot]);
        }
        else {
          $ts = new EquipmentTimeslot;
          $ts->et_equipment = $order->order_em;
          $time= "000000000000000000000000000000000000000000000000";
          for($i=$datestart;$i<=$dateend;$i++){
             $time[$i] = 1;
          }
          $ts->et_timeslot = $time;
          $ts->et_date = $ds;
          $ts->save();
        }
      }
      return;

    }

    public function checkAllocation($id){
      $now = Carbon::now('Asia/Jakarta');
      $now = Carbon::parse($now);
    //  dd($now);
      $now = $now->format('Y-m-d');
      // $data['alloc'] = DB::table('equipment')
      // ->join('equipment_many','equipment.equipment_id','=','equipment_many.em_equipment')
      // ->leftjoin(DB::raw("(select * from equipment_timeslot where et_date = ". $now." )"),function($join){
      //   $join->on("equipment_timeslot.et_equipment","=","equipment_many.et_id");
      // })
      // ->where('equipment.equipment_id',$id)
      // ->get();
      $query = "SELECT * FROM equipment e
                INNER JOIN equipment_many em on e.equipment_id = em.em_equipment
                LEFT JOIN (
                    SELECT * FROM equipment_timeslot where et_date = ".$now."
                ) t on t.et_equipment = em.em_id
                WHERE e.equipment_id = ".$id."
                ";
      $data['alloc'] = DB::select($query);
      $data['nav'] = 'history-occ';
      //dd($data);
      return view('pages/occ/allocation',$data);
    }


}
