<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // User → Goals through the pivot table
    public function goals()
{
    return $this->belongsToMany(\App\Models\Goal::class, 'user_goals')
        ->withTimestamps()
        ->withPivot('direction', 'target_value');
}


    // User → Recipes
    public function recipes()
    {
        return $this->hasMany(\App\Models\Recipe::class);
    }

    // User → Biometrics
    public function biometrics()
    {
        return $this->hasMany(\App\Models\Biometric::class);
    }

    // User → Meals
    public function meals()
    {
        return $this->hasMany(\App\Models\Meal::class);
    }
}
