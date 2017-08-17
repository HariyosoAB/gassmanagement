<form  action="{{url('/')}}/occ/edit-rootcause/{{$data->rc_id}}" method="post">

<div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h5 class="modal-title judul"><i class="fa fa-pencil" style="margin-right:10px"></i>Update Root Cause</h5>
    </div>
    <div class="modal-body">
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <label>Root Cause Name</label>
              <input class="form-control" type="text" name="nama" value="{{$data->rc_name}}" required>
              <input type="hidden" name="_token" value="{{csrf_token()}}">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <label>Root Cause Description</label>
              <input class="form-control" type="text" name="description" value="{{$data->rc_description}}" required >
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <label>Root Cause Type</label>
                <select class="form-control" name="type" required>
                    <option value=""></option>
                    <option value="0" @if($data->rc_pemutihan == 0) selected @endif>Internal</option>
                    <option value="1" @if($data->rc_pemutihan == 1) selected @endif>External</option>
                </select>
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
