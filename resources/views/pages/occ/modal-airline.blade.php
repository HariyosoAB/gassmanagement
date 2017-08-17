<form  action="{{url('/')}}/occ/edit-airline/{{$data->airline_id}}" method="post">

<div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h5 class="modal-title judul"><i class="fa fa-pencil" style="margin-right:10px"></i>Update Airline</h5>
    </div>
    <div class="modal-body">
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <label>Airline Name</label>
              <input class="form-control" type="text" name="nama" value="{{$data->airline_type}}" required>
              <input type="hidden" name="_token" value="{{csrf_token()}}">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <label>Airline Description</label>
              <input class="form-control" type="text" name="description" value="{{$data->airline_description}}" required >
            </div>
          </div>
        </div>
    </div>
    <div class="modal-footer">
      <button type="submit"  class="btn btn-primary"name="button">Submit</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>

  </div>
</div>
</form>
