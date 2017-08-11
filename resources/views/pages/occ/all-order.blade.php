@extends('master.master')
<div id="myModal" class="modal fade" role="dialog">

</div>
<div id="loading" class="text-center" style="position:fixed; margin-top:300px;z-index:9999; width:100%; height 100%;">
  <i class="fa fa-spinner fa-spin fa-5x"></i>
</div>
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
          <?php
            if($order->order_status == 3)
            {
              $datetime1 = strtotime($order->order_start);
              $datetime2 = strtotime($order->order_execute_at);
              $interval  = $datetime2 - $datetime1;
              $minutes   = round($interval / 60);
              //echo $minutes;

              $datetime1 = strtotime($order->order_end);
              $datetime2 = strtotime($order->order_finished_at);
              $interval  = $datetime2 - $datetime1;
              $minutes2   = round($interval / 60);
              //echo ".".$minutes2;
            }
            else {
              $minutes = 0;
              $minutes2 = 0;
            }

          ?>
          <tr @if((isset($order->order_delayed_end) || $minutes > 15 || $minutes2 > 15) && $order->order_status != 9) class="danger" @elseif($order->order_status == 3 && $minutes < 15 && $minutes2 < 15) class="success" @endif>
            <td>{{$order->order_swo}}</td>
            <td>
              {{$order->order_start}}
            </td>
            <td>
              {{$order->order_end}}
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

                @if(isset($order->order_delayed_until) || $minutes > 15 || $minutes2 > 15)
               <span class="label label-danger">Delayed</span>
               @else
              <span class="label label-success">Ontime</span>
                @endif
              @elseif($order->order_status == 5)
                Waiting For Execution
              @elseif($order->order_status == 10)
                Delayed
              @elseif($order->order_status == 9)
                Cancelled
              @endif
            </td>

            <td>
                <a href="{{url('/')}}/occ/order-detail/{{$order->order_id}}"><div role="button" class="btn btn-info btn-sm">

                  Details
                </div></a>
                @if((isset($order->order_delayed_end) || $minutes > 15 || $minutes2 > 15) && $order->order_status != 9)
                <a onclick="viewprobtag({{$order->order_id}})" style="padding:8px"class="btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal" id="delete"><i class="fa fa-warning" style="margin-right:0px;"></i></a>
                @endif
            </td>
          </tr>
          @endforeach
        </tbody>
    </table>
    <script type="text/javascript" src="{{url('/')}}/plugin/sweetalert/sweetalert2.min.js"></script>

<script>
	$(document).ready(function() {
    $('#loading').hide();

		$('#example').DataTable({
			responsive: true
		});
	} );

  function viewprobtag(id){
    $('#loading').show();
    $.get("{{url('/')}}/occ/probtag/"+id,function (data){
      //console.log(data);
        $('#loading').hide();
        $("#myModal").html(data);

    });
  }
</script>
@stop
