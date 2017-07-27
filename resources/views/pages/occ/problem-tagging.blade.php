@extends('master.master')

@section('judul')
<i class="fa fa-warning"></i>Warning! This order is late</p>
@stop

@section('content')


<form method="post" action="{{url('/')}}/occ/problem-tagging/{{$order->order_id}}">
    <div class="col-md-6" style="padding:0">
      <p class="judul">
      <div class="row">
        <div class="col-md-5">
          <div class="form-group">
            <input type="hidden" name="type" value="@if($delay=='execute')execute @else finish @endif">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <label for="">SWO Number</label>
            <p>{{$order->order_swo}}</p>
          </div>
        </div>
      </div>
      <div class="row">
        @if($delay == "execute")
        <div class="col-md-5">
          <div class="form-group">
            <label for="">Planned Start Time</label>
            <p>{{$order->order_start}}</p>
          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group">
            <label for="">Actual Start Time</label>
            <p>{{$time}}</p>
          </div>
        </div>
        @elseif($delay == "finish")
        <div class="col-md-5">
          <div class="form-group">
            <label for="">Planned Finish Time</label>
            <p>{{$order->order_end}}</p>
          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group">
            <label for="">Actual Finish Time</label>
            <p>{{$time}}</p>
          </div>
        </div>
        @endif
      </div>

    </div>
  	<div class="col-md-6" style="padding:0">
      <div class="row">
        <div class="form-group col-md-10">
          @if($delay== "execute")
          <label>This order is late in execution start time</label>
          @else
            <label>This order is late in execution finish time</label>
          @endif
          <p>Please insert the reason of delay</p>
          <select id="reasondelay" class="form-control"multiple="multiple" name="reason[]" required>
              <option value=""></option>
              @foreach($problems as $problem)
                <option value="{{$problem->rc_id}}">{{$problem->rc_name}}</option>
              @endforeach
          </select>
        </div>
      </div>

      <div class="row">
        <div class="form-group col-md-4">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>

    </div>



</form>
<script type="text/javascript">
 $(document).ready(function(){
   $('#reasondelay').select2();
 });
</script>
@stop
