<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountStatus extends Model{
    protected $table = 'accounts_status';
    protected $fillable = ['name'];
}