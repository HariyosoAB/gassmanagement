@extends('master.master')

@section('judul')
<i class="fa fa-refresh"></i> Orders in Execution
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
            <td style="padding-top:20px">{{$order->order_swo}}</td>
            <td style="padding-top:20px">{{$order->order_start}}</td>
            <td style="padding-top:20px">{{$order->order_end}}</td>
            <td style="padding-top:20px">{{$order->equipment_model}} (No: {{$order->em_no_inventory}})</td>
            <td style="padding-top:20px">{{$order->maintenance_description}}</td>
            <td style="padding-top:20px">{{$order->airline_type}}</td>
            <td style="padding-top:20px"><span class="label @if($order->order_urgency == 1) label-danger @elseif($order->order_urgency == 2) label-warning @elseif($order->order_urgency == 3) label-success @else label-default @endif">{{$order->urgency_level}}</span></td>
            <td>
              @if(Auth::user()->user_role == 2)
                <a href="{{url('/')}}/occ/finish/{{$order->order_id}}" style="margin-top: 5px" class="btn btn-md btn-primary">
                  <i class="fa fa-check" aria-hidden="true"></i>
                </a>
              @endif
                <a href="{{url('/')}}/occ/order-detail/{{$order->order_id}}" style="margin-top: 5px" class="btn btn-info btn-md">
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
