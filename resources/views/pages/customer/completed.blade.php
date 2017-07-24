@extends('master.master')

@section('judul')
completed
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
            <td>@if($prog->order_swo == null)
                  Not Available
                @else
                  {{$prog->order_swo}}
                @endif
            </td>
            <td>{{$prog->order_start}}</td>
            <td>{{$prog->equipment_model}}</td>
            <td>{{$prog->order_maintenance_type}}</td>
            <td>{{$prog->airline_type}}</td>
            <td>
                @if($prog->order_status == 1)
                  Waiting for approval
                @endif
                @if($prog->order_status == 3)
                     Completed
                @endif
            </td>
            <td>
              @if($prog->order_status == 1)
                <div id="cancel" onclick="cancellation({{$prog->order_id}})" role="button" class="btn btn-danger btn-sm">
                   Cancel Order
                </div>
              @endif

              <div role="button" class="btn btn-info btn-sm">
                  Details
              </div>
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
