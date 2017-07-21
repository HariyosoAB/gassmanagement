@extends('master.master')

@section('judul')
create order
@stop

@section('content')
<form method="post" action="{{url('/')}}/cust/create-order">
	<div class="col-md-6" style="padding:0">
		<div class="row">
			<div class="form-group col-md-6">
				<label>SWO Number</label>
				<input type="text" class="form-control inputs" name="swo" required>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-7">
				<label>Equipment</label>
				<select class="form-control inputs" name="equipment" required>
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
				<input type="text" class="form-control inputs" name="start" required/>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-5">
				<label>From</label>
				<input type="text" class="form-control inputs" name="from" required>
			</div>
			<div class="form-group col-md-5">
				<label>To</label>
				<input type="text" class="form-control inputs" name="to" required>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				<label>Unit</label>
				<select class="form-control inputs" name="unit" required>
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
				<input type="text" class="form-control inputs" name="acreg" required>
			</div>
			<div class="form-group col-md-5">
				<label>A/C Type</label>
				<select class="form-control inputs inputs" name="actype" required>
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
				<select class="form-control inputs" name="maintenance" required>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-5">
				<label>Urgency</label>
				<select class="form-control inputs" name="urgency" required>
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
				<input type="text" class="form-control inputs" name="address" required>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-7">
				<label>Airline</label>
				<select class="form-control inputs" name="airline" required>
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
$(function() {
    $('input[name="start"]').daterangepicker({
    	timePicker: true,
        singleDatePicker: true,
        locale: {
						format:'YYYY-MM-DD HH:mm:ss',

        }
    });

    $('input[name="end"]').daterangepicker({
    	timePicker: true,
        singleDatePicker: true,
        locale: {
            format: 'YYYY-MM-DD HH:mm:ss'
        }
    });
});
</script>
@stop
