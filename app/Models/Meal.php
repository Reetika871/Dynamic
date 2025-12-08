<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = ['user_id','recipe_id','served_on','servings'];
    protected $casts = ['served_on' => 'date'];

    public function user() { return $this->belongsTo(User::class); }
    public function recipe() { return $this->belongsTo(Recipe::class); }
}
