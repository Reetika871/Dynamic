<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use HasFactory; // <<— add this

    protected $fillable = [
        'user_id','title','instructions','calories',
        'protein_g','carbs_g','fiber_g','fat_g','carbon_grams'
    ];
}
