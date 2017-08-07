@extends('master.master')

@section('judul')
<i class="fa fa-shopping-cart"></i> Orders Waiting for Approval
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
            <th>Action</th>
          </tr>
        </tfoot>
        <tbody>
          @foreach($orders as $order)
          <tr>
            <td>{{$order->order_swo}}</td>
            <td>{{$order->order_start}}</td>
            <td>{{$order->order_end}}</td>
            <td>{{$order->equipment_model}}</td>
            <td>{{$order->maintenance_description}}</td>
            <td>{{$order->airline_type}}</td>
            <td>
                <a style="margin:5px;margin-left:0px" href="{{url('/')}}/occ/allocate/{{$order->order_id}}" ><div class="btn btn-sm btn-primary">
                  Manage Order
                </div></a>
                <a style="margin:5px;margin-left:0px" onclick="cancellation({{$order->order_id}})" ><div class="btn btn-sm btn-danger">
                  Cancel Order
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
