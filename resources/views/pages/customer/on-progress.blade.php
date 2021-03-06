@extends('master.master')

@section('judul')
on progress
@stop

@section('content')
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>SWO Number</th>
      <th>Start Time</th>
      <th>Equipment</th>
      <th>Maintenance Type</th>
      <th>Airline</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th>SWO Number</th>
      <th>Start Time</th>
      <th>Equipment</th>
      <th>Maintenance Type</th>
      <th>Airline</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </tfoot>
  <tbody>
    @foreach($progress as $prog)
    <tr >
      <td style="padding-top:20px">@if($prog->order_swo == null)
        Not Available
        @else
        {{$prog->order_swo}}
        @endif</td>
        <td style="padding-top:20px">{{$prog->order_start}}</td>
        <td style="padding-top:20px">{{$prog->equipment_model}}</td>
        <td style="padding-top:20px">{{$prog->order_maintenance_type}}</td>
        <td style="padding-top:20px">{{$prog->airline_type}}</td>
        <td style="padding-top:20px">
          @if($prog->order_status == 1)
          Waiting for approval
          @elseif($prog->order_status == 2)
          In Execution
          @elseif($prog->order_status == 5)
          Waiting For Execution
          @elseif($prog->order_status == 10)
          Delayed until {{$prog->order_delayed_until}}
          @endif
        </td>
        <td>
            @if($prog->order_status == 1 || $prog->order_status ==5 || $prog->order_status == 10 )
            <a id="cancel" onclick="cancellation({{$prog->order_id}})" style="margin-top: 5px" class="btn btn-danger btn-md">
             <i class="fa fa-times" aria-hidden="true"></i>
           </a>
           @endif
           @if($prog->order_status == 1)
           <a href="{{url('/')}}/cust/order-edit/{{$prog->order_id}}" style="margin-top: 5px" class="btn btn-primary btn-md">
             <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
           </a>
           @endif
           <a href="{{url('/')}}/cust/order-detail/{{$prog->order_id}}" style="margin-top: 5px" class="btn btn-info btn-md">
            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
          </a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
<script type="text/javascript" src="{{url('/')}}/plugin/sweetalert/sweetalert2.min.js"></script>

<script>
	$(document).ready(function() {
		$('#example').DataTable({
			responsive: true,
      "aaSorting": [],
		});
	} );

  function cancellation(orderid){
    swal({
      title: "Are you sure?",
      text: "You will not be able to recover this order data!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, cancel it!",
    }).then(function(){
      console.log(orderid);
      swal({
        title: "Cancellation",
        text: "Please enter the reason of cancellation",
        type: "info",
        html: '<form action="<?php echo url('')."/cust/cancel/" ?>'+orderid+'" method="post">'+
        '<div class="form-group" style="margin:10px 0px;"><input name="_token" value="<?php echo csrf_token() ?>"type="hidden"><textarea rows="10"name="reason" class="form-control" placeholder="Please enter the reason of cancellation" required></textarea></div>'+
        '<div class="form-group" style="margin:10px 0px;"><button type="submit" class="btn btn-primary">Submit</button></div>'+
        '</form>',
        showConfirmButton: false
      })
    });
  };
</script>

@stop
