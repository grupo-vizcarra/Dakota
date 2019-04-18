<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeLog extends Model{
    protected $table = 'type_log';
    protected $fillable = ['name'];

    public function accounts(){
        return $this->belongsToMany('App\User', 'log', 'type_log_id', 'account_id')->withTimestamps();
    }
}