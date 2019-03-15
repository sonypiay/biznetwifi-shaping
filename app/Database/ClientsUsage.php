<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class ClientsUsage extends Model
{
  public $timestamps = true;
  protected $table = 'clients_usage';
  protected $primaryKey = 'client_id';
}
