<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['pic_url','nav_url','sort','status','show_type','interval_time'];
}
