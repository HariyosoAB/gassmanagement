<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use DB;
class occController extends Controller
{
    public function previewOrder(){
        $data['nav'] = "preview";
        $data['orders'] = DB::table('order_f')
          ->join('equipment','order_f.order_equipment','=','equipment.equipment_id')
          ->join('actype','order_f.order_ac_type','=','actype.actype_id')
          ->join('airline','airline.airline_id','=','order_f.order_airline')
          ->where('order_f.order_status','=','1')
          ->orderBy('order_f.order_id','desc')
          ->get();
        return view('pages/occ/preview-order', $data);
    }

    public function onprogressTable(){
        $data['nav'] = "history-occ";
        return view('pages/occ/on-progress', $data);
    }

    public function completedTable(){
        $data['nav'] = "history-occ";
        return view('pages/occ/completed', $data);
    }

    public function canceledTable(){
        $data['nav'] = "history-occ";
        return view('pages/occ/canceled', $data);
    }

    public function allTable(){
        $data['nav'] = "history-occ";
        return view('pages/occ/all-order', $data);
    }
}
