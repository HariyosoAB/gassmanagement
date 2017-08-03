@extends('master.master')

@section('judul')
create order
@stop

@section('content')
<form method="post" action="{{url('/')}}/cust/create-order">
	<div class="col-md-6" style="padding:0">
		<div class="row">
			<div class="form-group col-md-7">
				<label>SWO Number</label>
				<input class="form-control"type="text" name="swo" required>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-9">
				<label>Equipment</label>
				<select class="form-control inputs inputs" name="equipment" required>
					<option value=""></option>
					@foreach($equipment as $equip)
						<option value="{{$equip->equipment_id}}">{{$equip->equipment_description}}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-5">
				<label>Start Time</label>
				<input type="text" class="form-control inputs" name="start" required/>
			</div>
			<div class="form-group col-md-5">
				<label>End Time</label>
				<input type="text" class="form-control inputs" name="end" required/>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-5">
				<label>From</label>
				<select id="fr"class="form-control inputs" style="padding:0px;" name="from" >
						<option value=""></option>
						<option value="Hangar 1">Hangar 1</option>
						<option value="Hangar 2">Hangar 2</option>
						<option value="Hangar 3">Hangar 3</option>
						<option value="Hangar 4">Hangar 4</option>
						<option value="lainnya">Other</option>
				</select>
				<input type="text" id="from" class="form-control inputs" style="margin-top:10px;" name="fromnew" required>
			</div>
			<div class="form-group col-md-5">
				<label>To</label>
				<select id="tu"class="form-control inputs" style="padding:0px;" name="to" >
						<option value=""></option>
						<option value="Hangar 1">Hangar 1</option>
						<option value="Hangar 2">Hangar 2</option>
						<option value="Hangar 3">Hangar 3</option>
						<option value="Hangar 4">Hangar 4</option>
						<option value="lainnya">Other</option>

				</select>
				<input type="text" id="to"class="form-control inputs" style="margin-top:10px;" name="tonew" required>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				<label>Unit</label>
				<select class="form-control inputs" name="unit" required>
					<option value=""></option>
					@foreach($units as $unit)
					<option value="{{$unit->unit_id}}">{{$unit->unit_name}}</option>
					@endforeach
				</select>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-5">
				<label>A/C Reg</label>
				<input type="text" class="form-control inputs" name="acreg" required>
			</div>
			<div class="form-group col-md-5">
				<label>A/C Type</label>
				<select class="form-control inputs inputs" name="actype" required>
					<option value=""></option>
					@foreach($actype as $act)
						<option value="{{$act->actype_id}}">{{$act->actype_code}}</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-6" style="padding:0">
		<div class="row">
			<div class="col-md-8 form-group">
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<label>Urgency</label>
				<select class="form-control" name="urgency" required>
					<option value=""></option>
					@foreach($urgency as $urgen)
					<option value="{{$urgen->urgency_id}}">{{$urgen->urgency_level}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-8">
				<label>Maintenance Type</label>
				<select class="form-control inputs" name="maintenance" required>
					<option value=""></option>
					@foreach($maintenance as $main)
						<option value="{{$main->maintenance_id}}">{{$main->maintenance_description}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-8">
				<label>Station</label>
				<select class="form-control" name="address" required>
					@foreach($station as $stat)
					<option value=""></option>

						<option value="{{$stat->station_id}}">{{$stat->station_name}}</option>
					@endforeach

				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-7">
				<label>Airline</label>
				<select class="form-control inputs" name="airline" required>
					<option value=""></option>
					@foreach($airline as $air)
						<option value="{{$air->airline_id}}">{{$air->airline_type}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-7">
				<label>Note</label>
				<textarea class="form-control inputs" rows="5" name="note" required></textarea>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-4">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	$(document).ready(function(){
			$('#from').hide();
			$('#to').hide();
			$('#to').prop('required',false);
			$('#from').prop('required',false);

	});
	$('#fr').change(function(){
		if(	$('#fr').val() == "lainnya"){
				$('#from').show();
				$('#from').props('required',true);

		}
		else {
			$('#from').hide();
			$("#from").val('');
			$('#from').props('required',false);

		}
	});

	$('#tu').change(function(){
		if(	$('#tu').val() == "lainnya"){
				$('#to').show();
				$('#to').prop('required',true);

		}
		else {
			$('#to').hide();
			$("#to").val('');
			$('#to').prop('required',false);

		}
	});


	$(function() {
		$('input[name="start"]').daterangepicker({
			timePicker: true,
			singleDatePicker: true,
			locale: {
				format:'YYYY-MM-DD HH:mm:ss',
			}
		});
	});
	$(function() {
		$('input[name="end"]').daterangepicker({
			timePicker: true,
			singleDatePicker: true,
			locale: {
				format:'YYYY-MM-DD HH:mm:ss',
			}
		});
	});

</script>
@stop
