<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
    use HasFactory;

    public function routes() 
    {
        return $this->hasMany('App\Models\Route');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // other users' interactions

    public function comments() 
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function likes() 
    {
        return $this->hasMany('App\Models\Like');
    }

    public function views() 
    {
        return $this->hasMany('App\Models\View');
    }
}
