@extends('master.master')

@section('judul')
<i class="fa fa-check"></i> Orders Completed
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
          <tr>
            <td>{{$order->order_swo}}</td>
            <td>{{$order->order_start}}</td>
            <td>{{$order->order_end}}</td>
            <td>{{$order->equipment_model}} (No: {{$order->em_no_inventory}})</td>
            <td>{{$order->maintenance_description}}</td>
            <td>{{$order->airline_type}}</td>
            <td><span class="label @if($order->order_urgency == 1) label-danger @elseif($order->order_urgency == 2) label-warning @elseif($order->order_urgency == 3) label-success @else label-default @endif">{{$order->urgency_level}}</span></td>
            <td>
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
</script>
@stop
