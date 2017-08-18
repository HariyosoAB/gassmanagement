@extends('master.master')

@section('content')
<div class="row" style="margin-top: 20px">
	<div class="form-group col-md-5">
		<canvas id="pieChart" style="height:250px; float: left"></canvas>
	</div>
	<div class="form-group col-md-7">
		<p class="judul">Data</p>
		<div class="row">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<h3>{{$all}}</h3>
				<p>All Orders</p>
			</div>
			<div class="col-lg-3 col-xs-6" style="color: #3c8dbc">
				<!-- small box -->
				<h3>
					<?php if($all==0) echo '0%'; 
					else echo $ontime/$all*100; 
					?>
				</h3>
				<p>On Time</p>
			</div>
			<div class="col-lg-3 col-xs-6" style="color: #f56954">
				<!-- small box -->
				<h3>
					<?php if($all==0) echo '0%'; 
					else echo $delay/$all*100;
					?>
				</h3>
				<p>Delay</p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-2 col-xs-5">
				<!-- small box -->
				<h4>{{$wait_apr}}</h4>
				<p style="font-size:10px">Waiting for Approval</p>
			</div>
			<div class="col-lg-2 col-xs-5">
				<!-- small box -->
				<h4>{{$wait_exc}}</h4>
				<p style="font-size:10px">Waiting for Execution</p>
			</div>
			<div class="col-lg-2 col-xs-5">
				<!-- small box -->
				<h4>{{$exec}}</h4>
				<p style="font-size:10px">In Execution</p>
			</div>
			<div class="col-lg-2 col-xs-5">
				<!-- small box -->
				<h4>{{$completed}}</h4>
				<p style="font-size:10px">Completed</p>
			</div>
			<div class="col-lg-2 col-xs-5">
				<!-- small box -->
				<h4>{{$cancel}}</h4>
				<p style="font-size:10px">Canceled</p>
			</div>
		</div>
		<div class="row" style="margin-top: 30px">
			<div class="form-group col-md-5">
				<a class="btn btn-success" style="margin-top: 15px" href="{{url('')}}/management/export-day/{{$waktu}}">Export xls</a>
			</div>
		</div>
	</div>
</div>
<div class="row" style="margin-top: 60px">
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
			@foreach($hasil as $order)
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
				<td style="padding-top:15px">{{$order->order_swo}}</td>
				<td style="padding-top:15px">
					{{$order->order_start}}
				</td>
				<td style="padding-top:20px">
					{{$order->order_end}}
				</td>
				<td style="padding-top:15px">{{$order->equipment_model}}</td>
				<td style="padding-top:15px">{{$order->maintenance_description}}</td>
				<td style="padding-top:15px">{{$order->airline_type}}</td>
				<td style="padding-top:15px">
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
					<a href="{{url('/')}}/management/order-detail/{{$order->order_id}}" style="margin-top: 5px" class="btn btn-md btn-info">
						<i class="fa fa-ellipsis-h" aria-hidden="true"></i>
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<div class="row">
<div class="form-group col-md-6" style="padding-left:0">
		<a href="{{url()->previous()}}" class="btn btn-info">Back</a>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#example').DataTable({
			responsive: true,
			"aaSorting": [],
		});

		$('input[name="start"]').daterangepicker({
			singleDatePicker: true,
			locale: {
				format:'YYYY-MM-DD',
			}
		});

		var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
		var pieChart = new Chart(pieChartCanvas);
		var PieData = [
		{
			value: {{$delay}},
			color: "#f56954",
			highlight: "#f56954",
			label: "Delay"
		},
		{
			value: {{$ontime}},
			color: "#3c8dbc",
			highlight: "#3c8dbc",
			label: "On time"
		},
		{
            value: {{$wait_apr}},
            color: "#00a65a",
            highlight: "#00a65a",
            label: "Waiting for Approval"
          },
          {
            value: {{$wait_exc}},
            color: "#f39c12",
            highlight: "#f39c12",
            label: "Waiting for Execution"
          },
          {
            value: {{$exec}},
            color: "#00c0ef",
            highlight: "#00c0ef",
            label: "In Execution"
          },
          {
            value: {{$cancel}},
            color: "#d2d6de",
            highlight: "#d2d6de",
            label: "Canceled"
          },
		];
		var pieOptions = {
			tooltipEvents: [],
			showTooltips: true,
			onAnimationComplete: function() {
				this.showTooltip(this.segments, true);
			},
			tooltipTemplate: "<%= label %> - <%= value %>",
          //Boolean - Whether we should show a stroke on each segment
          segmentShowStroke: true,
          //String - The colour of each segment stroke
          segmentStrokeColor: "#fff",
          //Number - The width of each segment stroke
          segmentStrokeWidth: 2,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 50, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps: 100,
          //String - Animation easing effect
          animationEasing: "easeOutBounce",
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate: true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: true,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
      };
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);

    } );
</script>
@stop