<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract{
    use Authenticatable, Authorizable;
    protected $table = 'accounts';
    protected $primaryKey = 'key';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'nickname', 'num_employer', 'email', 'status_id', 'data_id', 'rol_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function account_data(){
        return $this->hasOne('App\AccountsData', 'key', 'data_id');
    }

    public function rol(){
        return $this->belongsTo('App\Roles', 'rol_id');
    }

    public function status(){
        return $this->belongsTo('App\AccountStatus', 'status_id');
    }

    public function permissions(){
        return $this->belongsToMany('App\Permission', 'accounts_has_permissions', 'account_id', 'permission_id')->withTimestamps();
    }
    public function logs(){
        return $this->belongsToMany('App\TypeLog', 'log', 'account_id', 'type_log_id')->withTimestamps();
    }

    public function tasks(){
        return $this->belongsToMany('App\TaskType', 'accounts_has_tasks', 'account_id', 'task_id')->withPivot('details', 'status')->withTimestamps();
    }
}
