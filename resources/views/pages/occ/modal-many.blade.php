<form  action="{{url('/')}}/occ/edit-many/{{$data->em_id}}" method="post">

  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title judul"><i class="fa fa-pencil" style="margin-right:10px"></i>Update Item</h5>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Inventory Number</label>
                <input class="form-control" type="text" name="inv" value="{{$data->em_no_inventory}}"required>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Item Part Number</label>
                <input class="form-control" type="text" name="part"  value="{{$data->em_part_number}}"required >
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Servicable?</label>
                <select class="form-control" name="servicable" required>
                    <option value=""></option>
                    <option value="1" @if($data->em_servicable == 1) selected @endif>Yes</option>
                    <option value="0" @if($data->em_servicable == 0) selected @endif>No</option>
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
