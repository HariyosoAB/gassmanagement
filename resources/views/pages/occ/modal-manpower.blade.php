<div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h5 class="modal-title judul"><i class="fa fa-pencil" style="margin-right:10px"></i>Update Manpower</h5>
    </div>
    <form action="{{url('/')}}/occ/edit-manpower/{{$data->manpower_id}}" method="post">
    <div class="modal-body">
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <label>Manpower Name</label>
              <input class="form-control" type="text" name="nama" value="{{$data->manpower_nama}}" required>
              <input type="hidden" name="_token" value="{{csrf_token()}}">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <label>Manpower ID</label>
              <input class="form-control" type="text" name="no_peg" value="{{$data->manpower_no_pegawai}}" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <label>Manpower Capability</label>
              <input class="form-control" type="text" name="capability" value="{{$data->manpower_capability}}" required>
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
