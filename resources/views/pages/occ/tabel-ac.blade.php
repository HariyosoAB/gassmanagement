@extends('master.master')

@section('judul')
<i class="fa fa-check"></i> AC Type Data
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
              <a onclick="" style="margin-top: 5px" class="btn btn-md btn-danger">
                <i class="fa fa-times" aria-hidden="true"></i>
              </a>
              <a href="" style="margin-top: 5px" class="btn btn-md btn-info">
                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
              </a>
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
