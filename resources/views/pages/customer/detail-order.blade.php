@extends('master.master')

@section('judul')
detail order
@stop

@section('content')
<div class="col-md-6" style="padding:0">
	<div class="row">
		<div class="form-group col-md-6">
			<label>SWO Number</label>
			<p>{{$fields[0]->order_swo}}</p>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-6">
			<label>Equipment</label>
			<p>{{$fields[0]->equipment_description}}</p>
		</div>
	</div>

	<div class="row">
		<div class="form-group col-md-6">
			<label>Start Time</label>
			<p>{{$fields[0]->order_start}}</p>
		</div>
		<div class="form-group col-md-6">
			<label>End Time</label>
			<p>{{$fields[0]->order_end}}</p>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-6">
			<label>From</label>
			<p>{{$fields[0]->order_from}}</p>
		</div>
		<div class="form-group col-md-6">
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
	<div class="row">
		<div class="col-md-6 form-group">
			<label>Urgency</label>
			<p>{{$fields[0]->urgency_level}}</p>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-6">
			<label>Maintenance Type</label>
			<p>{{$fields[0]->maintenance_type}}</p>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-6">
			<label>Station</label>
			<p>{{$fields[0]->station_name}}</p>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-6">
			<label>Airline</label>
			<p>{{$fields[0]->airline_type}}</p>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-6">
			<label>Note</label>
			<p>{{$fields[0]->order_note}}</p>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-4">
			<a href="{{url('')}}/cust/on-progress" class="btn btn-primary">Back</a>
		</div>
	</div>
</div>
@stop
