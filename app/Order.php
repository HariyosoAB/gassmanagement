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
      'order_ticket_number',
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
      'order_cancellation',
      'order_delayed_until',
      'order_delayed_end',
      'order_execute_at',
      'order_finished_at',
    ];
}
