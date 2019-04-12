<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountData extends Model{
    protected $table = 'accounts_data';
    protected $fillable = ['key','names', 'first_name', 'last_name', 'birthdate', 'photo'];
}