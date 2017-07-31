<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderManpower extends Model
{
  protected $table = "order_manpower";
  public $timestamps = false;
  protected $primaryKey = "om_id";
  protected $fillable =
  [
    'order_id',
    'manpower_id',
    'om_type',
  ];
}
