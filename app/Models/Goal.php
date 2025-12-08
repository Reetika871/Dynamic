<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = ['label'];

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'user_goals')->withTimestamps();
    }
}
