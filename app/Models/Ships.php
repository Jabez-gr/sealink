<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ships extends Model
{
    /** @use HasFactory<\Database\Factories\ShipsFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'capacity_in_tonnes',
        'registration_number',
        'status',
    ];
}
