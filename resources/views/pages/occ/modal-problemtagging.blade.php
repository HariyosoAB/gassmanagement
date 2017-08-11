  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title judul"><i class="fa fa-warning"></i>Order Problem Tagging</h5>
      </div>
      <div class="modal-body">
        @if(isset($order->order_delayed_until))
        <div class="row">
            <div class="col-md-6">
              <label>Delay Start Time</label>
              <p>{{$order->order_delayed_until}}</p>
            </div>
            <div class="col-md-6">
              <label>Delay End Time</label>
              <p>{{$order->order_delayed_end}}</p>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-md-6">
              <label>Planned Execute Time</label>
              <p>{{$order->order_start}}</p>
            </div>
            <div class="col-md-6">
              <label>Actual Execute Time</label>
              @if(isset($order->order_execute_at))
                <p>{{$order->order_execute_at}}</p>
              @else
                <p>Pending</p>
              @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
              <label>Planned Finish Time</label>
              <p>{{$order->order_end}}</p>
            </div>
            <div class="col-md-6">
              <label>Actual Finish Time</label>
              @if(isset($order->order_finished_at))

              @else
              <p>Pending</p>
              @endif
              <p>{{$order->order_finished_at}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
              <label>Problem Tagging</label><br>
              @foreach($problem as $prob)
                <p class="label label-danger" style="font-size:15px;">{{$prob->rc_name}}</p>
              @endforeach
            </div>

        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
