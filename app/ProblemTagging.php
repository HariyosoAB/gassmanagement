<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProblemTagging extends Model
{
  protected $table = 'problem_tagging';
  protected $primaryKey = 'pt_id';
  public $timestamps = false;
  protected $fillable = [
      'order_id', 'pt_root_cause'
  ];
}
