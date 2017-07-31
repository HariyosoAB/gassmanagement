<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\ProblemTagging;
use App\OrderManpower;
use DB;
use Carbon\Carbon;
class occController extends Controller
{

    public function checkLateExec(Order $order){
      $now = Carbon::now();
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
        $now = Carbon::now();
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
      $now = Carbon::now();
      $now = $now->toDateTimeString();


      $startTime = Carbon::parse($order->order_start);
      $execTime = Carbon::parse($now);
      $totalDuration = $execTime->diffInMinutes($startTime);

      if($execTime->gt($startTime) && $totalDuration > 15)
      {
        $data['order'] = $order;
        $data['time'] = Carbon::now();
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
    //  dd($manpower);


      if($equipment[0]->em_status_on_service == 1){
        $data['eqtabrak'] = DB::table('order_f')
        ->join('equipment','equipment.equipment_id','=','order_f.order_equipment')
        ->join('equipment_many','equipment_many.em_id','=','order_f.order_em')
        ->where('order_f.order_status','=',2)
        ->where('order_f.order_em','=',$order->order_em)
        ->get();
      }

      if(isset($data['mantabrak']) && $equipment[0]->em_status_on_service == 0){

        if ($this->checkLateExec($order)) {
            return Redirect('/occ/wait-exec');
        }
        else {
            $data['order'] = $order;
            $data['time'] = Carbon::now();
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

    public function delayOrder($id,Request $request)
    {
      $order = Order::find($id);
      $order->order_delayed_until = $request->delay;
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
       $data['urgency'] = DB::table('urgency')->get();
       $data['manpower'] = DB::table('manpower')->orderBy('manpower_capability','desc')->get();
       $data['equipment'] = DB::table('equipment_many')->where('em_equipment','=',$data['orders'][0]->order_equipment)->get();
       return view('pages/occ/review-form',$data);
    }
    public function allocateOrder($id,Request $request)
    {
      //rombak disini
        $order = Order::find($id);
        $order->order_status = 5;
        $order->order_urgency = $request->urgency;

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
        $order->save();
        return Redirect('occ/preview-order');
    }


}
