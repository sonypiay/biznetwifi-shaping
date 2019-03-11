<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class AdminLogActivity extends Model
{
  public $timestamps = true;
  protected $primaryKey = 'log_id';
  protected $table = 'admin_log_activity';
}
