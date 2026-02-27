<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipments extends Model
{
    /** @use HasFactory<\Database\Factories\ShipmentsFactory> */
    use HasFactory;

    protected $fillable = [
        'cargo_id',
        'ship_id',
        'origin_port_id',
        'destination_port_id',
        'departure_date',
        'arrival_estimate',
        'actual_arrival_date',
        'status',
        'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'departure_date' => 'date',
        'arrival_estimate' => 'date',
        'actual_arrival_date' => 'date',
    ];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }
    public function ship()
    {
        return $this->belongsTo(Ships::class, 'ship_id');   
    }
    public function originPort()
    {
        return $this->belongsTo(Ports::class, 'origin_port_id');
    }
    public function destinationPort()
    {
        return $this->belongsTo(Ports::class, 'destination_port_id');   
    }
}
