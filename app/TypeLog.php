<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeLog extends Model{
    protected $table = 'type_log';
    protected $fillable = ['name'];
}