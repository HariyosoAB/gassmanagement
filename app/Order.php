<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "order_f";
    public $timestamps = false;
    protected $primaryKey = "order_id";
    protected $fillable =
    [
      'order_user',
      'order_swo',
      'order_equipment',
      'order_start',
      'order_from',
      'order_to',
      'order_unit',
      'order_ac_reg',
      'order_ac_type',
      'order_maintenance_type',
      'order_urgency',
      'order_address',
      'order_airline',
      'order_note',
      'order_end',
      'order_status',
      'order_operator',
      'order_wingman',
      'order_wingman2',
      'order_wingman3',
      'order_cancellation',
    ];
}
