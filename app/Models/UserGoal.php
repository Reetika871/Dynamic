<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGoal extends Model
{
    protected $fillable = ['user_id','goal_id','direction','target_value','period'];

    public function goal() { return $this->belongsTo(Goal::class); }
    public function user() { return $this->belongsTo(User::class); }
}
