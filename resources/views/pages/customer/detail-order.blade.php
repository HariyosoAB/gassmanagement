@extends('master.master')

@section('judul')
detail order
@stop

@section('content')
<div class="col-md-6" style="padding:0">
	<!-- details -->
	<div class="row">
		<div class="form-group col-md-6" style="margin-bottom:0">
			<label class="judul2">Details</label>
		</div>
	</div>
	<div class="row" style="margin-bottom:0">
		<div class="form-group col-md-6" style="margin-bottom:0">
			<label>SWO Number</label>
			<p>{{$fields[0]->order_swo}}</p>
		</div>
		<div class="col-md-6 form-group" style="margin-bottom:0">
			<label>Urgency</label>
			<p>{{$fields[0]->urgency_level}}</p>
		</div>
	</div>
	<div class="row" style="margin-bottom:0">
		<div class="form-group col-md-6" style="margin-bottom:0">
			<label>Maintenance Type</label>
			<p>{{$fields[0]->maintenance_type}}</p>
		</div>
		<div class="form-group col-md-6" style="margin-bottom:0">
			<label>Station</label>
			<p>{{$fields[0]->station_name}}</p>
		</div>
	</div>
	<div class="row" style="margin-bottom:0">
		<div class="form-group col-md-6" style="margin-bottom:0">
			<label>Airline</label>
			<p>{{$fields[0]->airline_type}}</p>
		</div>
		<div class="form-group col-md-6" style="margin-bottom:0">
			<label>Note</label>
			<p>{{$fields[0]->order_note}}</p>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-6">
			<label>Status</label>
			<p>
				<?php
				if($fields[0]->order_status == 3)
				{
					$datetime1 = strtotime($fields[0]->order_start);
					$datetime2 = strtotime($fields[0]->order_execute_at);
					$interval  = $datetime2 - $datetime1;
					$minutes   = round($interval / 60);
              //echo $minutes;

					$datetime1 = strtotime($fields[0]->order_end);
					$datetime2 = strtotime($fields[0]->order_finished_at);
					$interval  = $datetime2 - $datetime1;
					$minutes2   = round($interval / 60);
              //echo ".".$minutes2;
				}
				else {
					$minutes = 0;
					$minutes2 = 0;
				}

				?>
				@if($fields[0]->order_status == 1)
				Waiting for approval
				@elseif($fields[0]->order_status == 2)
				In Execution
				@elseif($fields[0]->order_status == 3)
				Completed

				@if(isset($fields[0]->order_delayed_until) || $minutes > 15 || $minutes2 > 15)
				<span class="label label-danger">Delayed</span>
				@else
				<span class="label label-success">Ontime</span>
				@endif
				@elseif($fields[0]->order_status == 5)
				Waiting For Execution
				@elseif($fields[0]->order_status == 10)
				Delayed
				@elseif($fields[0]->order_status == 9)
				Cancelled
				@endif
			</p>
		</div>
	</div>

	<!-- place n time -->
	<div class="row">
		<div class="form-group col-md-6" style="margin-bottom:0">
			<label class="judul2">Place & Time</label>
		</div>
	</div>
	<div class="row" style="margin-bottom:0">
		<div class="form-group col-md-6" style="margin-bottom:0">
			<label>Start Time</label>
			<p>{{$fields[0]->order_start}}</p>
		</div>
		<div class="form-group col-md-6" style="margin-bottom:0">
			<label>End Time</label>
			<p>{{$fields[0]->order_end}}</p>
		</div>
	</div>
	<div class="row" style="margin-bottom:0">
		<div class="form-group col-md-6" style="margin-bottom:0">
			<label>From</label>
			<p>{{$fields[0]->order_from}}</p>
		</div>
		<div class="form-group col-md-6" style="margin-bottom:0">
			<label>To</label>
			<p>{{$fields[0]->order_to}}</p>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-6">
			<label>Unit</label>
			<p>{{$fields[0]->unit_name}}</p>
		</div>
	</div>


	<div class="row">
		<div class="form-group col-md-6" style="margin-bottom:0">
			<label class="judul2">A/C</label>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-6">
			<label>A/C Reg</label>
			<p>{{$fields[0]->order_ac_reg}}</p>
		</div>
		<div class="form-group col-md-6">
			<label>A/C Type</label>
			<p>{{$fields[0]->actype_code}}</p>
		</div>
	</div>
</div>

<div class="col-md-6" style="padding:0">
	<!-- equipment -->
	<div class="row">
		<div class="form-group col-md-6" style="margin-bottom:0">
			<label class="judul2">Equipment</label>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-6">
			<label>Equipment</label>
			<p>{{$fields[0]->equipment_description}}</p>
		</div>
		@isset($manpower)
		<?php if(!$manpower->isEmpty() && Auth::user()->user_role == 2){?>
			<div class="form-group col-md-6">
				<label>No. Inventory</label>			
				<p>{{$fields[0]->em_no_inventory}}</p>
			</div>
			<?php } ?>
			@endisset
		</div>


		<!-- manpower -->
		@isset($manpower)
		<?php if(!$manpower->isEmpty() && Auth::user()->user_role == 2){?>
			<div class="row">
				<div class="form-group col-md-6" style="margin-bottom:0">
					<label class="judul2">Manpower</label>
				</div>
			</div>
			<div class="row">
				@foreach($manpower as $man)
				<div class="form-group col-md-6">
					<label>{{$man->manpower_nama}}</label>
					<p>{{$man->om_type}}</p>
				</div>
				@endforeach
			</div>
			<?php } ?>
			@endisset


			<?php if(!is_null($fields[0]->order_delayed_until)){?>
			<!-- delay -->
			<div class="row">
				<div class="form-group col-md-6" style="margin-bottom:0">
					<label class="judul2">Delay</label>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<label>Delay From</label>
					<p>{{$fields[0]->order_delayed_until}}</p>
				</div>
				<div class="form-group col-md-6">
					<label>Delay To</label>
					<p>{{$fields[0]->order_delayed_end}}</p>
				</div>
			</div>
			<?php }?>

			<?php if(!is_null($fields[0]->order_cancellation)){?>
			<!-- cancel -->
			<div class="row">
				<div class="form-group col-md-6" style="margin-bottom:0">
					<label class="judul2">Cancel</label>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<label>Reason</label>
					<p>{{$fields[0]->order_cancellation}}</p>
				</div>
			</div>
			<?php }?>


			<div class="row">
				<div class="form-group col-md-6">
					<a href="{{url()->previous()}}" class="btn btn-info">Back</a>
				</div>
			</div>
		</div>
		@stop
