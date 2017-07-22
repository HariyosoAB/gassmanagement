<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
      <table>
        <thead>
          <tr>
            <th>SWO Number</th>
            <th>Start Time</th>
            <th>Equipment</th>
            <th>Maintenance Type</th>
            <th>Urgency</th>
            <th>Airline</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($progress as $prog)
          <tr>
            <td>{{$prog->order_swo}}</td>
            <td>{{$prog->order_start}}</td>
            <td>{{$prog->equipment_model}}</td>
            <td>{{$prog->order_maintenance_type}}</td>
            <td>{{$prog->urgency_level}}</td>
            <td>{{$prog->airline_type}}</td>
            <td>
                @if($prog->order_status == 1)
                  Waiting for approval
                @endif
            </td>
            <td>
              <a href="#">Cancel Order</a>
              <a href="#">Details</a>
            </td>
          </tr>
          @endforeach
        </tbody>

      </table>
  </body>
</html>
