  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title judul"><i class="fa fa-plus" style="margin-right:10px"></i>{{$model}} Inventory Details</h5>
      </div>
      <div class="modal-body">
        <table id="many" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                      <th>Inventory Number</th>
                      <th>Item Part Number</th>
                      <th>Item Status</th>
                      <th>Servicable</th>

                      <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Inventory Number</th>
                    <th>Item Part Number</th>
                    <th>Item Status</th>
                    <th>Servicable</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach($datas as $data)
                  <tr>
                    <td>{{$data->em_no_inventory}}</td>
                    <td>{{$data->em_part_number}}</td>
                    <td>@if($data->em_status_on_service == 0)
                            Available
                        @else
                            In Use
                        @endif
                    </td>
                    <td>@if($data->em_servicable == 1)
                            Servicable
                        @else
                            Non Servicable
                        @endif
                    </td>
                    <td>
                      <a  onclick="edititem({{$data->em_id}})" style="margin-top: 5px" class="btn btn-md btn-primary">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                      </a>
                      <a onclick="deleteitem({{$data->em_id}})" style="margin-top: 5px" class="btn btn-md btn-danger">
                        <i class="fa fa-times" aria-hidden="true"></i>
                      </a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
