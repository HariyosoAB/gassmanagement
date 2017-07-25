@extends('master.master')

@section('judul')
edit order
@stop

@section('content')
<form method="post" action="{{url('/')}}/cust/order-edit/{{$fields->order_id}}">
	<div class="col-md-6" style="padding:0">
		<div class="row">
			<div class="form-group col-md-7">
				<label>Equipment</label>
				<select class="form-control inputs" name="equipment" required>
          <option value=""></option>
          @foreach($equipment as $equip)
            <option value="{{$equip->equipment_id}}" @if($equip->equipment_id == $fields->order_equipment) selected @endif > {{$equip->equipment_description}}</option>
          @endforeach
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-5">
				<label>Start</label>
				<input type="text" class="form-control inputs" name="start" value="{{$fields->order_start}}" required/>
			</div>
      <div class="form-group col-md-5">
				<label>End</label>
				<input type="text" class="form-control inputs" name="end" value="{{$fields->order_end}}" required/>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-5">
				<label>From</label>
        <select id="fr"class="form-control inputs" style="padding:0px;" name="from" required>
            <option value=""></option>
            <option value="Hangar 1" @if($fields->order_from == "Hangar 1") selected @endif>Hangar 1</option>
            <option value="Hangar 2" @if($fields->order_from == "Hangar 2") selected @endif>Hangar 2</option>
            <option value="Hangar 3" @if($fields->order_from == "Hangar 3") selected @endif>Hangar 3</option>
            <option value="Hangar 4" @if($fields->order_from == "Hangar 4") selected @endif>Hangar 4</option>
            <option value="lainnya" id="lain1">Other</option>

        </select>
				<input type="text" id="from"class="form-control inputs" style="margin-top:10px;" name="fromnew" value="{{$fields->order_from}}" required>
			</div>
			<div class="form-group col-md-5">
				<label>To</label>
        <select id="tu" class="form-control inputs" style="padding:0px;" name="to" required>
            <option value=""></option>
            <option value="Hangar 1" @if($fields->order_to == "Hangar 1") selected @endif>Hangar 1</option>
            <option value="Hangar 2" @if($fields->order_to == "Hangar 2") selected @endif>Hangar 2</option>
            <option value="Hangar 3" @if($fields->order_to == "Hangar 3") selected @endif>Hangar 3</option>
            <option value="Hangar 4" @if($fields->order_to == "Hangar 4") selected @endif>Hangar 4</option>
            <option value="lainnya" id="lain2">Other</option>

        </select>
				<input type="text" id="to" class="form-control inputs" style="margin-top:10px;" name="tonew" value="{{$fields->order_to}}" required>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				<label>Unit</label>
				<select class="form-control inputs" name="unit" value="{{$fields->order_unit}}" required>
					<option value=""></option>
          @foreach($units as $unit)
            <option value="{{$unit->unit_id}}" @if($unit->unit_id == $fields->order_unit) selected @endif > {{$unit->unit_name}}</option>
          @endforeach
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
          <option value=""></option>
          @foreach($actype as $act)
            <option value="{{$act->actype_id}}" @if($act->actype_id == $fields->order_ac_type) selected @endif > {{$act->actype_code}}</option>
          @endforeach
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-6" style="padding:0">
		<div class="row">
			<div class="form-group col-md-8">
				<label>Maintenance Type</label>
				<select class="form-control inputs" name="maintenance" value="{{$fields->order_maintenance_type}}" required>
          <option value=""></option>
          @foreach($maintenance as $main)
            <option value="{{$main->maintenance_id}}" @if($main->maintenance_id == $fields->order_maintenance_type) selected @endif > {{$main->maintenance_description}}</option>
          @endforeach
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
          <option value=""></option>
          @foreach($airline as $air)
            <option value="{{$air->airline_id}}" @if($air->airline_id == $fields->order_airline) selected @endif > {{$air->airline_type}}</option>
          @endforeach
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
    $(document).ready(function (){

      $('#to').hide();
      $('#to').prop('required',false);
      if(	$('#fr').val() != "Hangar 1" && $('#fr').val() != "Hangar 2" && $('#fr').val() != "Hangar 3" && $('#fr').val() != "Hangar 4"){
          $('#lain1').prop('selected',true);
          $('#from').show();
          $('#from').prop('required',true);
      }
      else{
          $('#from').val("");
          $('#from').hide();
          $('#from').prop('required',false);
      }

      if(	$('#tu').val() != "Hangar 1" && $('#tu').val() != "Hangar 2" && $('#tu').val() != "Hangar 3" && $('#tu').val() != "Hangar 4"){
          $('#lain2').prop('selected',true);
          $('#to').show();
          $('#to').prop('required',true);
      }
      else{
          $('#to').val("");
          $('#to').hide();
          $('#to').prop('required',false);
      }

    });

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
  $('#fr').change(function(){
		if(	$('#fr').val() == "lainnya"){
				$('#from').show();
        $('#from').val('');
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
        $('#to').val('');
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
