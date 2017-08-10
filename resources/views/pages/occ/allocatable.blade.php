
<div class="box box-header with-border"  style="margin-top:50px;">

<h2 class="judul"><i class="fa fa-list"></i>{{$alloc[0]->equipment_model}} Allocation || {{$date}}</h2>

<style media="screen">
    td{
      background-color: white;
    }
</style>
<div style="padding:10px;">

  <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th>Inventory Number</th>
        <th>00:00</th>
        <th>00:30</th>
        <th>01:00</th>
        <th>01:30</th>
        <th>02:00</th>
        <th>02:30</th>
        <th>03:00</th>
        <th>03:30</th>
        <th>04:00</th>
        <th>04:30</th>
        <th>05:00</th>
        <th>05:30</th>
        <th>06:00</th>
        <th>06:30</th>
        <th>07:00</th>
        <th>07:30</th>
        <th>08:00</th>
        <th>08:30</th>
        <th>09:00</th>
        <th>09:30</th>
        <th>10:00</th>
        <th>10:30</th>
        <th>11:00</th>
        <th>11:30</th>
        <th>12:00</th>
        <th>12:30</th>
        <th>13:00</th>
        <th>13:30</th>
        <th>14:00</th>
        <th>14:30</th>
        <th>15:00</th>
        <th>15:30</th>
        <th>16:00</th>
        <th>16:30</th>
        <th>17:00</th>
        <th>17:30</th>
        <th>18:00</th>
        <th>18:30</th>
        <th>19:00</th>
        <th>19:30</th>
        <th>20:00</th>
        <th>20:30</th>
        <th>21:00</th>
        <th>21:30</th>
        <th>22:00</th>
        <th>22:30</th>
        <th>23:00</th>
        <th>23:30</th>
      </tr>
    </thead>
    <!-- <tfoot>
    <tr>
    <th></th>
  </tr>
</tfoot> -->
<tbody>
  @foreach($alloc as $al)
  <tr>
    <td>
      {{$al->em_no_inventory}}
    </td>
    @if($al->et_timeslot != null)
    @for ($i = 0; $i < 48; $i++)
    @if($al->et_timeslot[$i])
    <td style="background-color:red"></td>
    @else
    <td></td>
    @endif
    <!-- <td>{{$al->et_timeslot[$i]}}</td> -->
    @endfor
    @else
    @for($i = 0; $i < 48; $i++)
    <td></td>
    @endfor
    @endif
  </tr>
  @endforeach
</tbody>
</table>
</div>

</div>
