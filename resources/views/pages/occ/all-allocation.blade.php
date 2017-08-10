@extends('master.master')

@section('judul')
<i class="fa fa-pie-chart"></i>View Allocation
@stop

@section('content')
<style media="screen">
    td{
      background-color: white;
    }
</style>


<div class="row">
  <div class="col-md-12">
    <form  >
          <div class="col-md-6">
            <div class="form-group">
              <label>Equipment</label>
              <select id="equipment" class="form-control" name="equipment" required>
                  <option value=""></option>
                  @foreach($equipment as $equip)
                  <option value="{{$equip->equipment_id}}">{{$equip->equipment_description}}</option>
                  @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3">
              <div class="form-group">
                  <label>Date</label>
                  <input id="date"class="form-control"type="text" name="date" value="">
              </div>
          </div>
          <div class="col-md-3">

              <div class="form-group" style="margin-top:25px;">
                <button type="button" id="allocbutton" class="btn btn-info" name="button">Check Allocation</button>
              </div>
          </div>

    </form>

  </div>
</div>


<div id = "allocationtable">
</div>
<div id="loading" class="text-center" style="margin-top:30px;">
  <i class="fa fa-spinner fa-spin fa-5x"></i>
</div>

<script type="text/javascript" src="{{url('/')}}/plugin/sweetalert/sweetalert2.min.js"></script>

<script>
$(document).ready(function() {
  $('#loading').hide();
});

$('#allocbutton').click(function(){
  //console.log("{{url('/')}}"+"/aa");
  $('#loading').show();
  $('#allocationtable').hide();

  var equipment = $('#equipment').val();
  var date =  $('#date').val();
   $.get("{{url('/')}}/occ/allocation/"+equipment+"/"+date+"",function (data){
        $('#loading').hide();
        $("#allocationtable").html(data);
        $('#example').DataTable({
          "scrollX": true
        });
        $('#allocationtable').show();

   });
});

   $(function() {
     $('input[name="date"]').daterangepicker({
       timePicker: false,
       singleDatePicker: true,
       locale: {
         format:'YYYY-MM-DD',
       }
     });
   });
</script>
@stop
