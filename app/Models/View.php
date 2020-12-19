<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    public function journey() 
    {
        return $this->belongsTo('App\Models\Journey');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
