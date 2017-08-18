<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class managementController extends Controller
{
	public function graph1(Request $request){
		$data['nav'] = 'report';
    	// $waktu = Carbon::now('Asia/Jakarta')->format('Y-m-d');
		$query = "select * from order_f where date(order_start)='".$request->tanggal."'";
		$hasil = DB::select($query);

		$data['hasil'] = DB::select("select * from order_f, equipment, actype, airline, maintenance where order_f.order_equipment=equipment.equipment_id and order_f.order_ac_type=actype.actype_id and airline.airline_id=order_f.order_airline and maintenance.maintenance_id=order_f.order_maintenance_type and date(order_f.order_start)='".$request->tanggal."'");

		$all = 0;
		$ontime = 0;
		$delay = 0;
		$wait_apr = 0;
		$wait_exc = 0;
		$exec = 0;
		$completed = 0;
		$cancel = 0;

		foreach($hasil as $key){
			$datetime1 = strtotime($key->order_start);
			$datetime2 = strtotime($key->order_execute_at);
			$interval  = $datetime2 - $datetime1;
			$minutes   = round($interval / 60);

			$datetime1 = strtotime($key->order_end);
			$datetime2 = strtotime($key->order_finished_at);
			$interval  = $datetime2 - $datetime1;
			$minutes2   = round($interval / 60);

			$all++;

			if(empty($key->order_delayed_end) && !empty($key->order_execute_at) && $minutes < 15 && $minutes2 < 15){
				$ontime++;
			}

			if(isset($key->order_delayed_end) || $minutes > 15 || $minutes2 > 15){
				$delay++;
			}

			if($key->order_status == 1){
				$wait_apr++;
			}

			if($key->order_status == 2){
				$exec++;
			}

			if($key->order_status == 3){
				$completed++;
			}

			if($key->order_status == 5){
				$wait_exc++;
			}if($key->order_status == 9){
				$cancel++;
			}
		}

		$data['ontime'] = $ontime;
		$data['delay'] = $delay;
		$data['all'] = $all;
		$data['wait_apr'] = $wait_apr;
		$data['wait_exc'] = $wait_exc;
		$data['exec'] = $exec;
		$data['completed'] = $completed;
		$data['cancel'] = $cancel;
		$data['waktu'] = $request->tanggal;

		return view('pages/management/graph1', $data);
	}

	public function graph2(Request $request){
		$data['nav'] = 'report';
    	// $waktu = Carbon::now('Asia/Jakarta')->format('Y-m-d');
    	$waktu = explode("-", $request->tanggal);
    	$tanggal = Carbon::create($waktu[0], $waktu[1], $waktu[2], 12, 0, 0);
    	$startWeek = $tanggal->startOfWeek()->format('Y-m-d');
    	$endWeek = $tanggal->endOfWeek()->format('Y-m-d');

		$query = "select * from order_f where date(order_start) between '".$startWeek."' and '".$endWeek."'";
		$hasil = DB::select($query);

		// dd($hasil);

		$data['hasil'] = DB::select("select * from order_f, equipment, actype, airline, maintenance where order_f.order_equipment=equipment.equipment_id and order_f.order_ac_type=actype.actype_id and airline.airline_id=order_f.order_airline and maintenance.maintenance_id=order_f.order_maintenance_type and date(order_f.order_start) between '".$startWeek."' and '".$endWeek."'");

		$all = 0;
		$ontime = 0;
		$delay = 0;
		$wait_apr = 0;
		$wait_exc = 0;
		$exec = 0;
		$completed = 0;
		$cancel = 0;

		foreach($hasil as $key){
			$datetime1 = strtotime($key->order_start);
			$datetime2 = strtotime($key->order_execute_at);
			$interval  = $datetime2 - $datetime1;
			$minutes   = round($interval / 60);

			$datetime1 = strtotime($key->order_end);
			$datetime2 = strtotime($key->order_finished_at);
			$interval  = $datetime2 - $datetime1;
			$minutes2   = round($interval / 60);

			$all++;

			if(empty($key->order_delayed_end) && !empty($key->order_execute_at) && $minutes < 15 && $minutes2 < 15){
				$ontime++;
			}

			if(isset($key->order_delayed_end) || $minutes > 15 || $minutes2 > 15){
				$delay++;
			}

			if($key->order_status == 1){
				$wait_apr++;
			}

			if($key->order_status == 2){
				$exec++;
			}

			if($key->order_status == 3){
				$completed++;
			}

			if($key->order_status == 5){
				$wait_exc++;
			}if($key->order_status == 9){
				$cancel++;
			}
		}

		$data['ontime'] = $ontime;
		$data['delay'] = $delay;
		$data['all'] = $all;
		$data['wait_apr'] = $wait_apr;
		$data['wait_exc'] = $wait_exc;
		$data['exec'] = $exec;
		$data['completed'] = $completed;
		$data['cancel'] = $cancel;
		$data['waktu'] = $request->tanggal;

		return view('pages/management/graph2', $data);
	}

	public function graph3(Request $request){
		$data['nav'] = 'report';
    	// $waktu = Carbon::now('Asia/Jakarta')->format('Y-m-d');
    	$waktu = explode("-", $request->tanggal);
    	$tanggal = Carbon::create($waktu[0], $waktu[1], $waktu[2], 12, 0, 0);
    	$startWeek = $tanggal->startOfMonth()->format('Y-m-d');
    	$endWeek = $tanggal->endOfMonth()->format('Y-m-d');

		$query = "select * from order_f where date(order_start) between '".$startWeek."' and '".$endWeek."'";
		$hasil = DB::select($query);

		// dd($hasil);

		$data['hasil'] = DB::select("select * from order_f, equipment, actype, airline, maintenance where order_f.order_equipment=equipment.equipment_id and order_f.order_ac_type=actype.actype_id and airline.airline_id=order_f.order_airline and maintenance.maintenance_id=order_f.order_maintenance_type and date(order_f.order_start) between '".$startWeek."' and '".$endWeek."'");

		$all = 0;
		$ontime = 0;
		$delay = 0;
		$wait_apr = 0;
		$wait_exc = 0;
		$exec = 0;
		$completed = 0;
		$cancel = 0;

		foreach($hasil as $key){
			$datetime1 = strtotime($key->order_start);
			$datetime2 = strtotime($key->order_execute_at);
			$interval  = $datetime2 - $datetime1;
			$minutes   = round($interval / 60);

			$datetime1 = strtotime($key->order_end);
			$datetime2 = strtotime($key->order_finished_at);
			$interval  = $datetime2 - $datetime1;
			$minutes2   = round($interval / 60);

			$all++;

			if(empty($key->order_delayed_end) && !empty($key->order_execute_at) && $minutes < 15 && $minutes2 < 15){
				$ontime++;
			}

			if(isset($key->order_delayed_end) || $minutes > 15 || $minutes2 > 15){
				$delay++;
			}

			if($key->order_status == 1){
				$wait_apr++;
			}

			if($key->order_status == 2){
				$exec++;
			}

			if($key->order_status == 3){
				$completed++;
			}

			if($key->order_status == 5){
				$wait_exc++;
			}if($key->order_status == 9){
				$cancel++;
			}
		}

		$data['ontime'] = $ontime;
		$data['delay'] = $delay;
		$data['all'] = $all;
		$data['wait_apr'] = $wait_apr;
		$data['wait_exc'] = $wait_exc;
		$data['exec'] = $exec;
		$data['completed'] = $completed;
		$data['cancel'] = $cancel;
		$data['waktu'] = $request->tanggal;

		return view('pages/management/graph2', $data);
	}

	public function export_day($waktu){
		// $waktu = Carbon::now('Asia/Jakarta')->format('Y-m-d');
		Excel::create($waktu, function($excel) use ($waktu){
			// $waktu = "2017-08-10";
			$hasil = DB::select("select * from order_f, equipment, actype, airline, maintenance, urgency, station, unit where unit.unit_id=order_f.order_unit and station.station_id=order_f.order_address and  urgency.urgency_id=order_f.order_urgency and order_f.order_equipment=equipment.equipment_id and order_f.order_ac_type=actype.actype_id and airline.airline_id=order_f.order_airline and maintenance.maintenance_id=order_f.order_maintenance_type and date(order_f.order_start)='".$waktu."'");

			$array = [];
			$array[0] = ['SWO Number','Maintenance Type','Airline','Urgency','Station','Start Time','End Time', 'From', 'To', 'Unit', 'A/C Reg', 'A/C Type', 'Note', 'Status'];
			// dd($array);

			$count = 1;
			foreach ($hasil as $key) {
				if($key->order_status == 3){
					$datetime1 = strtotime($key->order_start);
					$datetime2 = strtotime($key->order_execute_at);
					$interval  = $datetime2 - $datetime1;
					$minutes   = round($interval / 60);

					$datetime1 = strtotime($key->order_end);
					$datetime2 = strtotime($key->order_finished_at);
					$interval  = $datetime2 - $datetime1;
					$minutes2   = round($interval / 60);
				}else{
					$muntes = 0;
					$minutes2 = 0;
				}

				if($key->order_status == 1) $key->order_status = 'Waiting for approval';
				elseif($key->order_status == 2) $key->order_status = 'In Execution';
				elseif($key->order_status == 3){
					if(isset($key->order_delayed_until) || $minutes > 15 || $minutes2 > 15) $key->order_status = 'Completed - Delayed';
					else $key->order_status = 'Completed - Ontime';
				}else if($key->order_status == 5) $key->order_status = 'Waiting For Execution';
				elseif($key->order_status == 9) $key->order_status = 'Cancelled';
				elseif($key->order_status == 10) $key->order_status = 'Delayed';

				$array[$count] = [$key->order_swo, $key->maintenance_type, $key->airline_type, $key->urgency_level, $key->station_name, $key->order_start, $key->order_end, $key->order_from, $key->order_to, $key->unit_name, $key->order_ac_reg, $key->actype_code, $key->order_note, $key->order_status];
				$count++;
			}

			$excel->sheet('sheet1', function($sheet) use ($array) {
                    $sheet->fromArray($array, null, 'A1', false, false);
                    $sheet->cell('A1:N1', function($cell) {
                        $cell->setFontColor('#dd4b38');
                        $cell->setFontWeight('bold');
                        $cell->setFontSize(13);
                    });
                });

			// dd($array);
		})->download('xls');
	}

	public function export_week($waktu){
		// $waktu = Carbon::now('Asia/Jakarta')->format('Y-m-d');

    	$waktu = explode("-", $waktu);
    	$tanggal = Carbon::create($waktu[0], $waktu[1], $waktu[2], 12, 0, 0);
    	$startWeek = $tanggal->startOfWeek()->format('Y-m-d');
    	$endWeek = $tanggal->endOfWeek()->format('Y-m-d');

		Excel::create($startWeek."_".$endWeek, function($excel) use ($startWeek, $endWeek){
			// $waktu = "2017-08-10";
			$hasil = DB::select("select * from order_f, equipment, actype, airline, maintenance, urgency, station, unit where unit.unit_id=order_f.order_unit and station.station_id=order_f.order_address and  urgency.urgency_id=order_f.order_urgency and order_f.order_equipment=equipment.equipment_id and order_f.order_ac_type=actype.actype_id and airline.airline_id=order_f.order_airline and maintenance.maintenance_id=order_f.order_maintenance_type and date(order_f.order_start) between '".$startWeek."' and '".$endWeek."'");

			$array = [];
			$array[0] = ['SWO Number','Maintenance Type','Airline','Urgency','Station','Start Time','End Time', 'From', 'To', 'Unit', 'A/C Reg', 'A/C Type', 'Note', 'Status'];
			// dd($array);

			$count = 1;
			foreach ($hasil as $key) {
				if($key->order_status == 3){
					$datetime1 = strtotime($key->order_start);
					$datetime2 = strtotime($key->order_execute_at);
					$interval  = $datetime2 - $datetime1;
					$minutes   = round($interval / 60);

					$datetime1 = strtotime($key->order_end);
					$datetime2 = strtotime($key->order_finished_at);
					$interval  = $datetime2 - $datetime1;
					$minutes2   = round($interval / 60);
				}else{
					$muntes = 0;
					$minutes2 = 0;
				}

				if($key->order_status == 1) $key->order_status = 'Waiting for approval';
				elseif($key->order_status == 2) $key->order_status = 'In Execution';
				elseif($key->order_status == 3){
					if(isset($key->order_delayed_until) || $minutes > 15 || $minutes2 > 15) $key->order_status = 'Completed - Delayed';
					else $key->order_status = 'Completed - Ontime';
				}else if($key->order_status == 5) $key->order_status = 'Waiting For Execution';
				elseif($key->order_status == 9) $key->order_status = 'Cancelled';
				elseif($key->order_status == 10) $key->order_status = 'Delayed';

				$array[$count] = [$key->order_swo, $key->maintenance_type, $key->airline_type, $key->urgency_level, $key->station_name, $key->order_start, $key->order_end, $key->order_from, $key->order_to, $key->unit_name, $key->order_ac_reg, $key->actype_code, $key->order_note, $key->order_status];
				$count++;
			}

			$excel->sheet('sheet1', function($sheet) use ($array) {
                    $sheet->fromArray($array, null, 'A1', false, false);
                    $sheet->cell('A1:N1', function($cell) {
                        $cell->setFontColor('#dd4b38');
                        $cell->setFontWeight('bold');
                        $cell->setFontSize(13);
                    });
                });

			// dd($array);
		})->download('xls');
	}

	public function export_month($waktu){
		// $waktu = Carbon::now('Asia/Jakarta')->format('Y-m-d');

    	$waktu = explode("-", $waktu);
    	$tanggal = Carbon::create($waktu[0], $waktu[1], $waktu[2], 12, 0, 0);
    	$startWeek = $tanggal->startOfMonth()->format('Y-m-d');
    	$endWeek = $tanggal->endOfMonth()->format('Y-m-d');

		Excel::create($startWeek."_".$endWeek, function($excel) use ($startWeek, $endWeek){
			// $waktu = "2017-08-10";
			$hasil = DB::select("select * from order_f, equipment, actype, airline, maintenance, urgency, station, unit where unit.unit_id=order_f.order_unit and station.station_id=order_f.order_address and  urgency.urgency_id=order_f.order_urgency and order_f.order_equipment=equipment.equipment_id and order_f.order_ac_type=actype.actype_id and airline.airline_id=order_f.order_airline and maintenance.maintenance_id=order_f.order_maintenance_type and date(order_f.order_start) between '".$startWeek."' and '".$endWeek."'");

			$array = [];
			$array[0] = ['SWO Number','Maintenance Type','Airline','Urgency','Station','Start Time','End Time', 'From', 'To', 'Unit', 'A/C Reg', 'A/C Type', 'Note', 'Status'];
			// dd($array);

			$count = 1;
			foreach ($hasil as $key) {
				if($key->order_status == 3){
					$datetime1 = strtotime($key->order_start);
					$datetime2 = strtotime($key->order_execute_at);
					$interval  = $datetime2 - $datetime1;
					$minutes   = round($interval / 60);

					$datetime1 = strtotime($key->order_end);
					$datetime2 = strtotime($key->order_finished_at);
					$interval  = $datetime2 - $datetime1;
					$minutes2   = round($interval / 60);
				}else{
					$muntes = 0;
					$minutes2 = 0;
				}

				if($key->order_status == 1) $key->order_status = 'Waiting for approval';
				elseif($key->order_status == 2) $key->order_status = 'In Execution';
				elseif($key->order_status == 3){
					if(isset($key->order_delayed_until) || $minutes > 15 || $minutes2 > 15) $key->order_status = 'Completed - Delayed';
					else $key->order_status = 'Completed - Ontime';
				}else if($key->order_status == 5) $key->order_status = 'Waiting For Execution';
				elseif($key->order_status == 9) $key->order_status = 'Cancelled';
				elseif($key->order_status == 10) $key->order_status = 'Delayed';

				$array[$count] = [$key->order_swo, $key->maintenance_type, $key->airline_type, $key->urgency_level, $key->station_name, $key->order_start, $key->order_end, $key->order_from, $key->order_to, $key->unit_name, $key->order_ac_reg, $key->actype_code, $key->order_note, $key->order_status];
				$count++;
			}

			$excel->sheet('sheet1', function($sheet) use ($array) {
                    $sheet->fromArray($array, null, 'A1', false, false);
                    $sheet->cell('A1:N1', function($cell) {
                        $cell->setFontColor('#dd4b38');
                        $cell->setFontWeight('bold');
                        $cell->setFontSize(13);
                    });
                });

			// dd($array);
		})->download('xls');
	}

	public function detail($id){

      $data['nav'] = "report";
      // $data['fields'] = Order::find($id);
      $data['fields'] = DB::table('order_f')
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

      $data['manpower'] = DB::table('order_manpower')
      ->join('manpower', 'manpower.manpower_id', '=', 'order_manpower.manpower_id')
      ->where('order_manpower.order_id', '=', $id)
      ->get();

      // dd($data);

      return view('pages/customer/detail-order',$data);

    $data['nav'] = "preview";
    // $data['fields'] = Order::find($id);
    $data['fields'] = DB::table('order_f')
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

    $data['manpower'] = DB::table('order_manpower')
    ->join('manpower', 'manpower.manpower_id', '=', 'order_manpower.manpower_id')
    ->where('order_manpower.order_id', '=', $id)
    ->get();

    return view('pages/customer/detail-order',$data);

  }
}
