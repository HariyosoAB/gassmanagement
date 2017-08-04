@extends('master.master')

@section('judul')
Review order -- SWO No: <small style="font-family:'montserrat'">{{$orders[0]->order_swo}}</small>
@stop

@section('content')


<form method="post" action="{{url('/')}}/occ/allocate/{{$orders[0]->order_id}}">
    <div class="col-md-6" style="padding:0">
  		<div class="row">
  			<div class="form-group col-md-9">
  				<strong>Equipment</strong>
  				 <p>{{$orders[0]->equipment_model}} - {{$orders[0]->equipment_description}}</p>
  			</div>
  		</div>

  		<div class="row">
  			<div class="form-group col-md-5">
  				<strong>Start Time</strong>
          <p>{{$orders[0]->order_start}}</p>
  			</div>
  			<div class="form-group col-md-5">
  				<strong>End Time</strong>
  				<p>{{$orders[0]->order_end}}</p>
  			</div>
  		</div>
  		<div class="row">
  			<div class="form-group col-md-5">
  				<strong>From</strong>
          <p>{{$orders[0]->order_from}}</p>
  			</div>
  			<div class="form-group col-md-5">
  				<strong>To</strong>
          <p>{{$orders[0]->order_to}}</p>
  			</div>
  		</div>
  		<div class="row">
  			<div class="form-group col-md-5">
  				<strong>Unit</strong>
  				<p>{{$orders[0]->unit_name}}</p>
  			</div>
        <div class="form-group col-md-5">
  				<strong>Airline</strong>
  				 <p>{{$orders[0]->airline_type}}</p>
  			</div>
  		</div>
  	</div>
  	<div class="col-md-6" style="padding:0">
      <div class="row">
  			<div class="form-group col-md-5">
  				<strong>A/C Reg</strong>
          <p>{{$orders[0]->order_ac_reg}}</p>
  			</div>
  			<div class="form-group col-md-5">
  				<strong>A/C Type</strong>
          <p>{{$orders[0]->actype_description}}</p>
  			</div>
  		</div>
  		<div class="row">
  			<div class="form-group col-md-8">
  				<strong>Maintenance Type</strong>
  				 <p>{{$orders[0]->maintenance_description}}</p>
  			</div>
  		</div>
  		<div class="row">
  			<div class="form-group col-md-8">
  				<strong>Address</strong>
          <p>{{$orders[0]->order_address}}</p>
  			</div>
  		</div>

  		<div class="row">
  			<div class="form-group col-md-7">
  				<strong>Note</strong>
          <p>{{$orders[0]->order_note}}</p>
  			</div>
  		</div>
  	</div>

    <div class="row">
      <div class="col-md-12">
        <p class="judul">Allocate order</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
          <div class="row">
            <div class="form-group col-md-5" style="margin-bottom:10px">
                <button type="button" name="button" id="delaythis" class="btn btn-danger" style="float:left">Delay this order</button>
                <button type="button" name="button" id="close" class="btn btn-primary" style="float:left;margin-left:10px;"><i class="fa fa-close" style="margin:0px"></i></button>
            </div>
          </div>

          <div class="row" id="delayform">
            <div class="form-group col-md-6">
              <label>Delay Start Time</label>
              <input class="form-control" type="text" id="delaystart" name="delaystart" value="">
            </div>
            <div class="form-group col-md-6">
              <label>Delay End Time</label>
              <input class="form-control" type="text" id="delayend" name="delayend" value="">
            </div>
          </div>



          <div class="row">
            <div class="col-md-6 form-group">
                <label>Operator</label>
                <select class="form-control" name="operator" required>
                    <option value=""></option>
                    @foreach($manpower as $man)
                      <option value="{{$man->manpower_id}}">{{$man->manpower_capability}} -- {{$man->manpower_nama}} -- {{$man->manpower_no_pegawai}} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label>Wingman</label>
                <select class="form-control" id="wing" name="wingman[]" multiple required>
                    <option value=""></option>
                    @foreach($manpower as $man)
                      <option value="{{$man->manpower_id}}">{{$man->manpower_capability}} -- {{$man->manpower_nama}} -- {{$man->manpower_no_pegawai}} </option>
                    @endforeach
                </select>
            </div>
          </div>
          <div class="row">


              <div class="col-md-6 form-group">
                <label>{{$orders[0]->equipment_model}} Allocation</label>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <select class="form-control" name="alloceqp" required>
                    <option value=""></option>
                    <optgroup label="{{$orders[0]->equipment_description}}">
                    @foreach($equipment as $equip)
                        <option value="{{$equip->em_id}}">-No Inventory: {{$equip->em_no_inventory}}</option>
                    @endforeach
                    </optgroup>

                </select>
              </div>


          </div>

      </div>
      <div class="col-md-6">

      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-4">
        <button type="submit" class="btn btn-primary" style="float:left">Approve</button>
        <div class="" style="float:left;margin-left:10px">
          <a href="{{url('/')}}/occ/checkallocation/{{$orders[0]->equipment_id}}" target="_blank">
            <div class="btn btn-info" >
              Check equipment allocation
            </div>
          </a>
        </div>
      </div>
    </div>

</form>
<script type="text/javascript">
 $(document).ready(function(){
   $('#wing').select2();
   $('#close').hide();
   $('#delayform').hide();

 });

 $(function() {
   $('input[name="delaystart"]').daterangepicker({
     timePicker: true,
     singleDatePicker: true,
     locale: {
       format:'YYYY-MM-DD HH:mm:ss',
     }
   }).val('');
 });
 $(function() {
   $('input[name="delayend"]').daterangepicker({
     timePicker: true,
     singleDatePicker: true,
     locale: {
       format:'YYYY-MM-DD HH:mm:ss',
     }
   }).val('');
 });
 $('#delaythis').click(function(){
   $('#delayform').show(500);
   $('#delaystart').prop('required',true);
   $('#delayend').prop('required',true);
   $('#close').show(500);
 });

 $('#close').click(function(){
   $('#delaystart').val('');
   $('#delayend').val('');
   $('#delaystart').prop('required',false);
   $('#delayend').prop('required',false);
    $('#delayform').hide(500);
    $('#close').hide(500);


 });

</script>
@stop
