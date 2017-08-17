<form  action="{{url('/')}}/occ/edit-equipment/{{$data->equipment_id}}" method="post">

  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title judul"><i class="fa fa-plus" style="margin-right:10px"></i>Update Equipment Type</h5>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Equpment LC</label>
                <input class="form-control" type="text" name="nama" value="{{$data->equipment_lc}}"required>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Equipment Description</label>
                <input class="form-control" type="text" name="description"  value="{{$data->equipment_description}}"required >
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Equipment Model</label>
                <input class="form-control" type="text" name="model" value="{{$data->equipment_model}}" required >
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
