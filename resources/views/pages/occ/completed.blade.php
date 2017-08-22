@extends('master.master')
<div id="myModal" class="modal fade" role="dialog">

</div>
<div id="loading" class="text-center" style="position:fixed; margin-top:300px;z-index:9999; width:100%; height 100%;">
  <i class="fa fa-spinner fa-spin fa-5x"></i>
</div>
@section('judul')
<i class="fa fa-list"></i> Orders Completed
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
</table>
<script type="text/javascript" src="{{url('/')}}/plugin/sweetalert/sweetalert2.min.js"></script>

<script>
  $(document).ready(function() {
    $('#loading').hide();

    $('#example').DataTable({
      responsive: true,
      "aaSorting": [],
      processing: true,
      serverSide: true,
      ajax: '{{url('')}}/occ/ajaxCompleted',
      columns: [
      { data: 'order_swo', name: 'order_swo' },
      { data: 'order_start', name: 'order_start' },
      { data: 'order_end', name: 'order_end' },
      { data: 'equipment_model', name: 'equipment_model' },
      { data: 'maintenance_description', name: 'maintenance_description' },
      { data: 'airline_type', name: 'airline_type' },
      { data: 'order_status', name: 'order_status' },
      { data: 'order_id', name: 'order_id' }
      ],
      "rowCallback": function( row, data, index ) {
        if ( data.order_status == 1 ) {
          $('td', row).eq(6).html( 'Waiting for approval' );
        }else if( data.order_status == 2 ) {
          $('td', row).eq(6).html( 'In Execution' );
        }else if( data.order_status == 5 ) {
          $('td', row).eq(6).html( 'Waiting For Execution' );
        }else if( data.order_status == 9 ) {
          $('td', row).eq(6).html( 'Cancelled' );
        }else if( data.order_status == 10 ) {
          $('td', row).eq(6).html( 'Delayed' );
          $('td', row).addClass( 'danger' );
        }else if( data.order_status == "Completed - Delayed" ) {
          $('td', row).addClass( 'danger' );
          $('td', row).eq(7).html("<a onclick='viewprobtag("+data.order_id+")' style='margin-top: 5px' class='btn btn-md btn-danger' data-toggle='modal' data-target='#myModal' id='delete'><i class='fa fa-warning' style='margin-right:0px;'></i></a>");
        }else if( data.order_status == "Completed - Ontime" ) {
          $('td', row).addClass( 'success' );
        }

        if ( data.order_id != 0 ) {
          $('td', row).eq(7).html( "<a href='{{url('')}}/occ/order-detail/"+data.order_id+"' style='margin-top: 5px' class='btn btn-info btn-md'><i class='fa fa-ellipsis-h' aria-hidden='true'></i></a>" );
        }

        if( data.order_status == "Completed - Delayed" || data.order_status == 10 ) {
          $('td', row).eq(7).append("<a style='margin-left: 10px; margin-top: 5px' onclick='viewprobtag("+data.order_id+")' style='margin-top: 5px' class='btn btn-md btn-danger' data-toggle='modal' data-target='#myModal' id='delete'><i class='fa fa-warning' style='margin-right:0px;'></i></a>");
        }
      }
    });
  } );

  function viewprobtag(id){
    $('#loading').show();
    $.get("{{url('/')}}/occ/probtag/"+id,function (data){
      console.log(data);
      $('#loading').hide();
      $("#myModal").html(data);

    });
  }
</script>
@stop
