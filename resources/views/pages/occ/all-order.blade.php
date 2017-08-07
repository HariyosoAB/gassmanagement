@extends('master.master')

@section('judul')
<i class="fa fa-list"></i> All Orders
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
              <th>Status</th>
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
            <th>Status</th>

            <th>Action</th>
          </tr>
        </tfoot>
        <tbody>
          @foreach($orders as $order)
          <tr @isset($order->order_delayed_end) class="danger" @endisset>
            <td>{{$order->order_swo}}</td>
            <td>
              {{$order->order_start}}
              @isset($order->order_delayed_until)
              <br>
              <strong style="color:red">Delayed until {{$order->order_delayed_until}}</strong>
              @endisset
            </td>
            <td>{{$order->order_end}}
              @isset($order->order_delayed_end)
              <br>
              <strong style="color:red">Delayed until {{$order->order_delayed_end}}</strong>
              @endisset
            </td>
            <td>{{$order->equipment_model}}</td>
            <td>{{$order->maintenance_description}}</td>
            <td>{{$order->airline_type}}</td>
            <td>
              @if($order->order_status == 1)
                Waiting for approval
              @elseif($order->order_status == 2)
                In Execution
              @elseif($order->order_status == 3)
                Completed
              @elseif($order->order_status == 5)
                Waiting For Execution
              @elseif($order->order_status == 10)
                Delayed
              @elseif($order->order_status == 9)
                Cancelled

              @endif
            </td>

            <td>
                <a href="{{url('/')}}/occ/allocate/{{$order->order_id}}" style="margin:5px;margin-left:0px"><div class="btn btn-sm btn-info">
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
