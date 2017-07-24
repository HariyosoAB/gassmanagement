@extends('master.master')

@section('judul')
create order
@stop

@section('content')
<form method="post" action="{{url('/')}}/cust/order-edit/{{$fields->order_id}}">
	<div class="col-md-6" style="padding:0">
		<div class="row">
			<div class="form-group col-md-7">
				<label>Equipment</label>
				<select class="form-control inputs" name="equipment" value="{{$fields->order_equipment}}" required>
          <option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-5">
				<label>Start</label>
				<input type="text" class="form-control inputs" name="start" value="{{$fields->order_start}}" required/>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-5">
				<label>From</label>
				<input type="text" class="form-control inputs" name="from" value="{{$fields->order_from}}" required>
			</div>
			<div class="form-group col-md-5">
				<label>To</label>
				<input type="text" class="form-control inputs" name="to" value="{{$fields->order_to}}" required>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				<label>Unit</label>
				<select class="form-control inputs" name="unit" value="{{$fields->order_unit}}" required>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
				</select>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-5">
				<label>A/C Reg</label>
				<input type="text" class="form-control inputs" name="acreg"  value="{{$fields->order_ac_reg}}"required>
			</div>
			<div class="form-group col-md-5">
				<label>A/C Type</label>
				<select class="form-control inputs inputs" name="actype" value="{{$fields->order_ac_type}}" required>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-6" style="padding:0">
		<div class="row">
			<div class="form-group col-md-8">
				<label>Maintenance Type</label>
				<select class="form-control inputs" name="maintenance" value="{{$fields->order_maintenance_type}}" required>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-8">
				<label>Address</label>
				<input type="text" class="form-control inputs" name="address" value="{{$fields->order_address}}"required>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-7">
				<label>Airline</label>
				<select class="form-control inputs" name="airline" value="{{$fields->order_airline}}" required>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-7">
				<label>Note</label>
				<textarea class="form-control inputs" rows="5" name="note" required>{{$fields->order_note}}</textarea>
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
	$(function() {
		$('input[name="start"]').daterangepicker({
			timePicker: true,
			singleDatePicker: true,
			locale: {
				format:'YYYY-MM-DD HH:mm:ss',
			}
		});
	});
</script>
@stop
