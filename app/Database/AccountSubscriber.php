<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class AccountSubscriber extends Model
{
    public $timestamps = false;
    protected $table = 'account_subscriber';
    protected $primaryKey = null;
    public $incrementing = false;
}
