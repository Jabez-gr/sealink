<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    /** @use HasFactory<\Database\Factories\CrewFactory> */
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'role',
        'phone_number',
        'nationality',
        'ship_id',
        'is_active',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the full name of the crew member.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";    

    }

    public function ship()
    {
        return $this->belongsTo(Ships::class, 'ship_id');
    }
}
