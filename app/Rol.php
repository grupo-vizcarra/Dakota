<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model{
    protected $table = 'roles';
    protected $fillable = ['name'];

    public function permissions(){
        return $this->belongsToMany('App\Permission', 'permissions_default', 'rol_id', 'permission_id')->withTimestamps();
    }
}