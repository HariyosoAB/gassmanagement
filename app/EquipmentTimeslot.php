<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentTimeslot extends Model
{
  protected $table = "equipment_timeslot";
  public $timestamps = false;
  protected $primaryKey = "et_id";
  protected $fillable =
  [
    'et_equipment',
    'et_timeslot',
    'et_date',
  ];
}
