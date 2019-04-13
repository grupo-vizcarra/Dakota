<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountStatus extends Model{
    protected $table = 'accounts_status';
    protected $fillable = ['name'];

    public function accounts(){
        return $this->hasMany('App\User', 'status_id', 'id');
    }
}