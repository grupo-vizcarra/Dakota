<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountData extends Model{
    protected $table = 'accounts_data';
    protected $fillable = ['key','names', 'first_name', 'last_name', 'birthdate', 'photo'];

    public function account(){
        return $this->belongsTo('App\User','id', 'data_id');
    }
}