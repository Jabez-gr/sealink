<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ports extends Model
{
    /** @use HasFactory<\Database\Factories\PortsFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'port_type',
        'coordinates',
        'depth',
        'docking_capacity',
        'max_vessel_size',
        'security_level',
        'customs_authorized',
        'operational_hours',
        'port_manager',
        'port_contact_info',
        'is_active',
    ];
}
