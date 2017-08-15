@extends('master.master')

@section('judul')
<i class="fa fa-check"></i> Orders Completed
@stop

@section('content')
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
              <th>A/C Type Code</th>
              <th>A/C Type Description</th>
            </tr>
        </thead>
        <tfoot>
          <tr>
            <th>A/C Type Code</th>
            <th>A/C Type Description</th>
          </tr>
        </tfoot>
        <tbody>
          @foreach($datas as $data)
          <tr>
            <td>{{$data->actype_code}}</td>
            <td>{{$data->actype_description}}</td>
            <td>
                <a href="{{url('/')}}/occ/order-detail/{{$order->order_id}}"><div role="button" class="btn btn-info btn-sm">
                  Details
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
			responsive: true,
      "aaSorting": [],
		});
	} );
</script>
@stop
