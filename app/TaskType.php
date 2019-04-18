<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskType extends Model{
    protected $table = 'task_types';
    protected $fillable = ['name'];

    public function accounts(){
        return $this->belongsToMany('App\User', 'accounts_has_tasks', 'task_id', 'account_id')->withPivot('details', 'status')->withTimestamps();
    }
}