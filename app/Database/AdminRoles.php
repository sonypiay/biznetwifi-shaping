<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class AdminRoles extends Model
{
  public $timestamps = true;
  protected $table = 'users';
  protected $primaryKey = 'username';
  public $incrementing = false;
}
