@extends('master.master')

@section('judul')
<i class="fa fa-warning"></i>Warning! Manpower/Equipment is unavailable</p>
@stop

@section('content')


    <div class="col-md-6" style="padding:0">
      <p class="judul">
      <div class="row">
        <div class="col-md-5">
          <div class="form-group">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <h1 class="judul" style="font-size:20px;"><i class="fa fa-barcode"></i>SWO Number</h1>
            <p>{{$order->order_swo}}</p><a target="_blank" href="{{url('/')}}/occ/order-detail/{{$order->order_id}}">View Order Details</a>
          </div>
        </div>
      </div>
      @isset($eqtabrak)
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <h1 class="judul" style="font-size:20px;"><i class="fa fa-wrench"></i>Equipment is being used in another order</h1>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-5">
          <div class="form-group">
            <label for="">Equipment Information</label>
            <p>{{$eqtabrak[0]->equipment_description}} </p><p>-- No Inv.: {{$eqtabrak[0]->em_no_inventory}}</p>
          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group">
            <label for="">Being Used In</label>
            <p>Order Swo : {{$eqtabrak[0]->order_swo}}</p>
          </div>
        </div>
      </div>
      @endisset
      @isset($mantabrak)
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <h1 class="judul" style="font-size:20px;"><i class="fa fa-user"></i>Operator/Wingman is currently working on another order</h1>
            </div>
          </div>
        </div>
        <!-- <div class="row">
          <div class="col-md-5">
            <div class="form-group">
              <label for="">Manpower Information</label>
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <label for="">Currently Working On</label>
            </div>
          </div>
        </div> -->
        <div class="row">
          <div class="col-md-10">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                          <th>Nama Pegawai</th>
                          <th>Working On</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($mantabrak as $man)
                      <?php if($man->om_type == "operator")$nabrakop = 1; else $nabrakwing=1; ?>
                      <tr>
                        <td>{{$man->manpower_nama}}</td>
                        <td>SWO: {{$man->order_swo}}</td>
                      </tr>
                      @endforeach
                    </tbody>
              </table>
          </div>
          <!-- <div class="col-md-5">
            <div class="form-group">
              <p>{{$man->manpower_nama}}</p>
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <p>Order Swo : {{$man->order_swo}}</p>
            </div>
          </div> -->
        </div>
      @endisset

    </div>
  	<div class="col-md-6" style="padding:0">
      <div class="row">
        <div class="form-group col-md-10">
          <h1 class="judul" style="font-size:20px;margin-bottom:0px;"><i class="fa fa-list"></i>Please choose an option</h1>
          <br>
          <div role="button"class="btn btn-primary" id="allocbutton">
            Reallocate
          </div>
          <div role="button"class="btn btn-info" id="delaybutton">
            Delay this order
          </div>
        </div>
      </div>

      <form action="{{url('/')}}/occ/realloc/{{$order->order_id}}" method="post" id="allocation">
        <p class="judul" style="font-size:25px">Reallocation Form</p>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @isset($mantabrak)
              @foreach($mantabrak as $man)
                  <input type="hidden" name="deletedman[]" value="{{$man->om_id}}">
              @endforeach
        @endisset

        @if(isset($nabrakop))
        <div class="row">
          <div class="form-group col-md-10">
            <label for="">Operator Reallocation </label>
            <select class="form-control" name="operator" id="reman" required>
              <option value=""></option>

                @foreach($manpower as $man)
                  <option value="{{$man->manpower_id}}" @if($man->manpower_status == 1) disabled @endif>{{$man->manpower_nama}} -- {{$man->manpower_capability}} @if($man->manpower_status == 1)Unavailable @endif</option>
                @endforeach
            </select>
          </div>
        </div>
        @endisset
        @if(isset($nabrakwing))
        <div class="row">
          <div class="form-group col-md-10">
            <label for="">Wingman Reallocation </label>
            <select class="form-control" name="wingman[]" id="rewing" multiple required>
              <option value=""></option>

                @foreach($manpower as $man)
                  <option value="{{$man->manpower_id}}" @if($man->manpower_status == 1) disabled @endif>{{$man->manpower_nama}} -- {{$man->manpower_capability}} @if($man->manpower_status == 1)Unavailable @endif</option>
                @endforeach
            </select>
          </div>
        </div>
        @endisset

        @if(isset($eqtabrak))
        <div class="row">
          <div class="form-group col-md-10">
            <label for="">Equipment Reallocation </label>
            <select class="form-control" name="equipment" id="requip" required>
              <option value=""></option>
              @foreach($equipment as $equip)
                <option value="{{$equip->em_id}}" @if($equip->em_status_on_service == 1)disabled @endif>No-Inv:{{$equip->em_no_inventory}} @if($equip->em_status_on_service == 1)Unavailable @endif</option>
              @endforeach
            </select>
          </div>
        </div>
        @endisset

      <div class="row">
        <div class="form-group col-md-10">
          <button type="submit" class="btn btn-primary" style="float:left">Execute Order</button> <a href="{{url('/')}}/occ/checkallocation/{{$order->order_equipment}}/{{$order->order_start}}" target="_blank" style="margin-left:10px"><div class="btn btn-info">Check Equipment Allocation</div></a>
        </div>
      </div>
    </form>

      <form action="{{url('/')}}/occ/delayorder/{{$order->order_id}}" method="post" id="delay">
        <p class="judul" style="font-size:25px">Delay Form</p>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
          <div class="form-group col-md-5">
            <label for="">Delay Start Time </label>
              <input type="text" class="form-control inputs" name="delaystart" required/>
          </div>
          <div class="form-group col-md-5">
            <label for="">Delay End Time </label>
              <input type="text" class="form-control inputs" name="delayend" required/>
          </div>


          @isset($mantabrak)
            @foreach($mantabrak as $man)
              @if($man->om_type == "operator")
                <input type="hidden" name="optabrak" value="optabrak">
              @else
                <input type="hidden" name="wingtabrak" value="wingtabrak">
              @endif
            @endforeach
          @endisset

          @isset($eqtabrak)
            <input type="hidden" name="eqtabrak" value="eqtabrak">
          @endisset
        </div>

        <div class="row">
          <div class="form-group col-md-12">
            <button type="submit" class="btn btn-primary" style="float:left">Submit</button>
            <a href="{{url('/')}}/occ/checkallocation/{{$order->order_equipment}}/{{$order->order_start}}" target="_blank" style="margin-left:10px"><div class="btn btn-info">Check Equipment Allocation</div></a>
          </div>
        </div>

      </form>

    </div>




<script type="text/javascript">
 $(document).ready(function(){

   $(function() {
     $('input[name="delaystart"]').daterangepicker({
       timePicker: true,
       singleDatePicker: true,
       locale: {
         format:'YYYY-MM-DD HH:mm:ss',
       }
     });
   });
   $(function() {
     $('input[name="delayend"]').daterangepicker({
       timePicker: true,
       singleDatePicker: true,
       locale: {
         format:'YYYY-MM-DD HH:mm:ss',
       }
     });
   });


   $('#reman').select2({
     "language": {
      "noResults": function(){
          return "No Available Manpower";
      }
    },
   });
   $('#rewing').select2({
     "language": {
      "noResults": function(){
          return "No Available Manpower";
      }
    },
   });

   $('#requip').select2({
     "language": {
      "noResults": function(){
          return "No Available Equipment";
      }
    },
  });
  $('#allocation').hide();
  $('#delay').hide();



 });

 $('#allocbutton').click(function(){
   $('#delay').hide(500);
   $('#allocation').show(500);


 });


  $('#delaybutton').click(function(){
    $('#allocation').hide(500);
    $('#delay').show(500);

  });


</script>
@stop
