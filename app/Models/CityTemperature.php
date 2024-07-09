<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityTemperature extends Model
{
    use HasFactory;

    protected $fillable = ['city', 'temperature', 'full_data'];

    protected $casts = [
        'full_data' => 'array',
    ];
}
