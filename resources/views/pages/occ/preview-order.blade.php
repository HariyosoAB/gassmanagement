@extends('master.master')

@section('judul')
Preview Order
@stop

@section('content')
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
              <th>Start Time</th>
              <th>Equipment</th>
              <th>Maintenance Type</th>
              <th>Airline</th>
              <th>Action</th>
            </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Start Time</th>
            <th>Equipment</th>
            <th>Maintenance Type</th>
            <th>Airline</th>
            <th>Action</th>
          </tr>
        </tfoot>
        <tbody>
          @foreach($orders as $order)
          <tr>
            <td>{{$order->order_start}}</td>
            <td>{{$order->equipment_model}}</td>
            <td>{{$order->order_maintenance_type}}</td>
            <td>{{$order->order_airline}}</td>
            <td>
                <a href="{{url('/')}}/occ/order_"><div class="btn btn-primary">
                  Review Order
                </div></a>
                <a href="#"><div class="btn btn-danger">
                  Delete Order
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
