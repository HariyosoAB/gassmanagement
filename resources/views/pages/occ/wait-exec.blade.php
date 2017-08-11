@extends('master.master')

@section('judul')
<i class="fa fa-clock-o"></i> Orders Waiting for Execution
@stop

@section('content')
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
              <th>SWO Number</th>
              <th>Start Time</th>
              <th>End Time</th>
              <th>Equipment</th>
              <th>Maintenance Type</th>
              <th>Airline</th>
              <th>Urgency</th>
              <th>Action</th>
            </tr>
        </thead>
        <tfoot>
          <tr>
            <th>SWO Number</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Equipment</th>
            <th>Maintenance Type</th>
            <th>Airline</th>
            <th>Urgency</th>
            <th>Action</th>
          </tr>
        </tfoot>
        <tbody>
          @foreach($orders as $order)
          <tr @isset($order->order_delayed_until) class="danger" @endisset >
            <td>{{$order->order_swo}}</td>
            <td>{{$order->order_start}}
              @isset($order->order_delayed_until)
              <br>
                <strong style="color:red;">  Delayed Until {{$order->order_delayed_until}}</strong>
              @endisset
          </td>
            <td>{{$order->order_end}}
              @isset($order->order_delayed_end)
              <br>
                <strong style="color:red;">  Delayed Until {{$order->order_delayed_end}}</strong>
              @endisset
            </td>
            <td>{{$order->equipment_model}} (No: {{$order->em_no_inventory}})</td>
            <td>{{$order->maintenance_description}}</td>
            <td>{{$order->airline_type}}</td>
            <td><span class="label @if($order->order_urgency == 1) label-danger @elseif($order->order_urgency == 2) label-warning @elseif($order->order_urgency == 3) label-success @else label-default @endif">{{$order->urgency_level}}</span></td>
            <td>
                <a href="{{url('/')}}/occ/execute/{{$order->order_id}}"><div class="btn btn-sm btn-primary">
                  Execute
                </div>
              </a>
              <a onclick="cancellation({{$order->order_id}})" ><div class="btn btn-sm btn-danger">
                Cancel Order
              </div></a>
                <a href="{{url('/')}}/occ/order-detail/{{$order->order_id}}"><div role="button" class="btn btn-info btn-sm">
                  Details
                </div></a>
            </td>
          </tr>
          @endforeach
        </tbody>
    </table>
    <script type="text/javascript" src="{{url('/')}}/plugin/sweetalert/sweetalert2.min.js"></script>

<script>
	$(document).ready(function() {
		$('#example').DataTable({
			responsive: true
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
          html: '<form action="<?php echo url('')."/occ/cancel/" ?>'+orderid+'" method="post">'+
         '<div class="form-group" style="margin:10px 0px;"><input name="_token" value="<?php echo csrf_token() ?>"type="hidden"><textarea rows="10"name="reason" class="form-control" placeholder="Please enter the reason of cancellation" required></textarea></div>'+
          '<div class="form-group" style="margin:10px 0px;"><button type="submit" class="btn btn-primary">Submit</button></div>'+
         '</form>',
         showConfirmButton: false
       })
      });
    };
</script>
@stop
