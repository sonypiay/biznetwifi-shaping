<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class UsersPanel extends Model
{
  public $timestamps = false;
  protected $table = 'users';
  protected $primaryKey = 'username';
  public $incrementing = false;
}
