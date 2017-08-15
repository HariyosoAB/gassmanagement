@extends('master.master')

@section('judul')
<i class="fa fa-close"></i> Orders Cancelled
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
            <td style="padding-top:20px">{{$order->order_swo}}</td>
            <td style="padding-top:20px">{{$order->order_start}}</td>
            <td style="padding-top:20px">{{$order->order_end}}</td>
            <td style="padding-top:20px">{{$order->equipment_model}}</td>
            <td style="padding-top:20px">{{$order->maintenance_description}}</td>
            <td style="padding-top:20px">{{$order->airline_type}}</td>
            <td>
                <a href="{{url('/')}}/occ/order-detail/{{$order->order_id}}" style="margin-top: 5px" class="btn btn-md btn-info">
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
</script>
@stop
