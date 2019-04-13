<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model{
    protected $table = 'permissions';
    protected $fillable = ['name'];

    public function roles(){
        return $this->belongsToMany('App\Rol', 'permissions_default', 'permission_id', 'rol_id')->withTimestamps();
    }
}