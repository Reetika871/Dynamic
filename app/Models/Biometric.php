<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Biometric extends Model
{
    protected $fillable = ['user_id','measured_on','weight_kg','systolic','diastolic'];
    protected $casts = ['measured_on' => 'date'];

    public function user() { return $this->belongsTo(User::class); }
}
