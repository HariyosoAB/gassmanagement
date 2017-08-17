@extends('master.master')
<div id="loading" class="text-center" style="position:fixed; margin-top:300px;z-index:9999; width:100%; height 100%;">
  <i class="fa fa-spinner fa-spin fa-5x"></i>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title judul"><i class="fa fa-plus" style="margin-right:10px"></i>Insert New Equipment Type</h5>
      </div>
      <div class="modal-body">
        <form  action="{{url('/')}}/occ/insert-equipment" method="post">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Equpment LC</label>
                <input class="form-control" type="text" name="nama" required>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Equipment Description</label>
                <input class="form-control" type="text" name="description" required >
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Equipment Model</label>
                <input class="form-control" type="text" name="model" required >
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

<div id="itemModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title judul"><i class="fa fa-plus" style="margin-right:10px"></i>Add Inventory Item</h5>
      </div>
      <div class="modal-body" id="modbod">
        <form id="inventoryForm" method="post">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Equipment Model</label>
                <p id="model"></p>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Inventory Number</label>
                <input class="form-control" type="text" name="inv" required >
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Part Number</label>
                <input class="form-control" type="text" name="part" required >
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Servicable?</label>
                  <select class="form-control" name="servicable" required>
                      <option value=""></option>
                      <option value="1">Yes</option>
                      <option value="0">No</option>
                  </select>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer" >
        <button type="submit"  class="btn btn-primary"name="button">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </form>

    </div>
  </div>
</div>
@section('judul')
<i class="fa fa-list"></i> Equipment Data <a  data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary" style="margin-left:5px"><i class="fa fa-plus" ></i></a>
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
              <th>Equipment LC</th>
              <th>Equipment Description</th>
              <th>Equipment Model</th>
              <th>Action</th>
            </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Equipment LC</th>
            <th>Equipmen Description</th>
            <th>Equipment Model</th>
            <th>Action</th>
          </tr>
        </tfoot>
        <tbody>
          @foreach($datas as $data)
          <tr>
            <td>{{$data->equipment_lc}}</td>
            <td>{{$data->equipment_description}}</td>
            <td>{{$data->equipment_model}}</td>
            <td>
              <a onclick="edit({{$data->equipment_id}})" data-toggle="modal" data-target="#editModal" style="margin-top: 5px" class="btn btn-md btn-primary">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
              </a>
              <a onclick="cancellation({{$data->equipment_id}})" style="margin-top: 5px" class="btn btn-md btn-danger">
                <i class="fa fa-times" aria-hidden="true"></i>
              </a>
              <a  onclick="additem({{$data->equipment_id}},'{{$data->equipment_model}}')" data-toggle="modal" data-target="#itemModal" style="margin-top: 5px" class="btn btn-md btn-info">
                <i class="fa fa-plus" aria-hidden="true"></i>
              </a>
              <a  onclick="table({{$data->equipment_id}})" data-toggle="modal" data-target="#editModal" style="margin-top: 5px" class="btn btn-md btn-default">
                <i class="fa fa-folder-open" aria-hidden="true"></i>
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
    $('#loading').hide();

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
        window.location = "{{url('/')}}/occ/delete-equipment/" + id;
      });
    };
  function edit(id){
    $.get("{{url('/')}}/occ/edit-equipment/"+id,function (data){
        $("#editModal").html(data);
    });
  }
  function additem(id,model){
    var s = model;
    console.log(s);
    var url = "{{url('/')}}/occ/add-equipment/"+id;
    $("#model").html(s);
    $("#inventoryForm").prop('action',url);
  }
  function edititem(id){
    $('#editModal').html("<div class='modal-dialog'><div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal'>&times;</button><h5 class='modal-title judul'><istyle='margin-right:10px'></i></h5></div><div class='modal-body' id='modbod'><div id='loading' class='text-center' style='margin-top:20px'><i class='fa fa-spinner fa-spin fa-5x'></i></div></div><div class='modal-footer' ></div></div></div>");
    $.get("{{url('/')}}/occ/edit-many/"+id,function (data){
      $("#editModal").html(data);

    });

  }
  function table(id){
    $('#loading').show();

    $.get("{{url('/')}}/occ/many-equipment/"+id,function (data){

        $("#editModal").html(data);
        $('#many').DataTable({
    			responsive: true,
          "aaSorting": [],
    		});
        $('#loading').hide();

    });
  }
  function deleteitem(id){
      swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Delete it!",
      }).then(function(){
        window.location = "{{url('/')}}/occ/delete-many/" + id;
      });
    };

</script>
@stop
