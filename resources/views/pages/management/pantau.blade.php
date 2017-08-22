<!DOCTYPE html>
<html>
@include('master/head')
<body>
	<div class="head">
		<div class="logo desktop"><p>GMF Aircraft Support Services</p></div>
		<div class="logo mobile"><p>GASS</p></div>
	</div>
	<div class="outter">
		<div class="outter2">
			<div class="content col-md-12" style="padding:10px !important">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>SWO Number</th>
							<th>Start Time</th>
							<th>End Time</th>
							<th>Equipment (No. Inventory)</th>
							<th>Maintenance Type</th>
							<th>A/C Reg</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach($hasil as $cek)
						<tr>
							<td>{{$cek->order_swo}}</td>
							<td>{{$cek->order_start}}</td>
							<td>{{$cek->order_end}}</td>
							<td>{{$cek->equipment_lc}} <?php if(!empty($cek->em_no_inventory)) echo '('.$cek->em_no_inventory.')';?> </td>
							<td>{{$cek->maintenance_type}}</td>
							<td>{{$cek->order_ac_reg}}</td>
							<td>
								<?php
								if($cek->order_status == 3)
								{
									$datetime1 = strtotime($cek->order_start);
									$datetime2 = strtotime($cek->order_execute_at);
									$interval  = $datetime2 - $datetime1;
									$minutes   = round($interval / 60);
              //echo $minutes;

									$datetime1 = strtotime($cek->order_end);
									$datetime2 = strtotime($cek->order_finished_at);
									$interval  = $datetime2 - $datetime1;
									$minutes2   = round($interval / 60);
              //echo ".".$minutes2;
								}
								else {
									$minutes = 0;
									$minutes2 = 0;
								}

								?>
								@if($cek->order_status == 1)
								Waiting for approval
								@elseif($cek->order_status == 2)
								In Execution
								@elseif($cek->order_status == 5)
								Waiting For Execution
								@elseif($cek->order_status == 10)
								Delayed
								@endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<div class="row">
					<div class="form-group col-md-6">
						<a href="{{url()->previous()}}" class="btn btn-info">Back</a>
					</div>
				</div>
			</div>
			<div class="footer">
				Copyright © 2017 - Shafly Naufal A & Hariyoso Ario B
			</div>
		</div>
	</div>
</body>
<script>
	$(document).ready(function() {
		setInterval(function() {
			cache_clear()
		}, 300000);
	});

	function cache_clear() {
		window.location.reload(true);
	}
</script>

</html>