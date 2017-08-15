@extends('master.master')

@section('judul')
<i class="fa fa-cubes"></i> {{$eq->equipment_model}} (No INV. {{$eq->em_no_inventory}}) || {{$date}} Allocation
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
              <th>A/C Type</th>
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
          @foreach($order as $ord)
          <tr>
            <td>{{$ord->order_swo}}</td>
            <td>
              @if(isset($ord->order_delayed_until))
                <?php
                $date = new DateTime($ord->order_delayed_until);
                $date = $date->format('H:i:s');
                echo $date;
                ?>
              @else
                  <?php
                  $date = new DateTime($ord->order_start);
                  $date = $date->format('H:i:s');
                  echo $date;
                  ?>
              @endif
            </td>
            <td>
              @if(isset($ord->order_delayed_end))
                <?php
                $date = new DateTime($ord->order_delayed_end);
                $date = $date->format('H:i:s');
                echo $date;
                ?>
              @else
                <?php
                $date = new DateTime($ord->order_end);
                $date = $date->format('H:i:s');
                echo $date;
                ?>
              @endif
            </td>
            <td>{{$ord->equipment_model}} (No: {{$ord->em_no_inventory}})</td>
            <td>{{$ord->maintenance_description}}</td>
            <td>{{$ord->airline_type}}</td>
            <td><span class="label @if($ord->order_urgency == 1) label-danger @elseif($ord->order_urgency == 2) label-warning @elseif($ord->order_urgency == 3) label-success @else label-default @endif">{{$ord->urgency_level}}</span></td>
            <td>
                {{$ord->order_ac_reg}}
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
