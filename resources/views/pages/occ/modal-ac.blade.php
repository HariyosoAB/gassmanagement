<div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h5 class="modal-title judul"><i class="fa fa-pencil" style="margin-right:10px"></i>Update AC Type</h5>
    </div>
    <form action="{{url('/')}}/occ/edit-ac/{{$data->actype_id}}" method="post">
    <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>AC Type Code</label>
              <input class="form-control" type="text" name="code" value="{{$data->actype_code}}">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>AC Type Description</label>
              <input class="form-control" type="text" name="description" value="{{$data->actype_description}}">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit"  class="btn btn-primary" name="button">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </form>

  </div>
</div>
