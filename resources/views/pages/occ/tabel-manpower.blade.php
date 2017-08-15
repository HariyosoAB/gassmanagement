@extends('master.master')

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title judul"><i class="fa fa-plus" style="margin-right:10px"></i>Insert Manpower</h5>
      </div>
      <div class="modal-body">
        <form  action="{{url('/')}}/occ/insert-manpower" method="post">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Manpower Name</label>
                <input class="form-control" type="text" name="nama" required>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Manpower ID</label>
                <input class="form-control" type="text" name="no_peg"  required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Manpower Capability</label>
                <input class="form-control" type="text" name="capability" required>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit"  class="btn btn-primary"name="button">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </form>

    </div>
  </div>
</div>

<div id="editModal" class="modal fade" role="dialog">
</div>
@section('judul')
<i class="fa fa-list"></i> Manpower Data <a  data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary" style="margin-left:5px"><i class="fa fa-plus" ></i></a>
@stop

@section('content')
@if (session('failed'))
		<div class="alert alert-danger">
				{{ session('failed') }}
		</div>
@endif
@if (session('success'))
		<div class="alert alert-success">
				{{ session('success') }}
		</div>
@endif
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
              <th>Manpower Name</th>
              <th>Manpower ID</th>
              <th>Manpower Capability</th>
              <th>Action</th>
            </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Manpower Name</th>
            <th>Manpower ID</th>
            <th>Manpower Capability</th>
            <th>Action</th>
          </tr>
        </tfoot>
        <tbody>
          @foreach($datas as $data)
          <tr>
            <td>{{$data->manpower_nama}}</td>
            <td>{{$data->manpower_no_pegawai}}</td>
            <td>{{$data->manpower_capability}}</td>
            <td>
              <a  onclick="edit({{$data->manpower_id}})" data-toggle="modal" data-target="#editModal" style="margin-top: 5px" class="btn btn-md btn-primary">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
              </a>
              <a onclick="cancellation({{$data->manpower_id}})" style="margin-top: 5px" class="btn btn-md btn-danger">
                <i class="fa fa-times" aria-hidden="true"></i>
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

  function cancellation(id){
      swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Delete it!",
      }).then(function(){
        window.location = "{{url('/')}}/occ/delete-manpower/" + id;
      });
    };
  function edit(id){
    $.get("{{url('/')}}/occ/edit-manpower/"+id,function (data){
        $("#editModal").html(data);
    });
  }

</script>
@stop
