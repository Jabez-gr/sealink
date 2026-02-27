<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    /** @use HasFactory<\Database\Factories\ClientsFactory> */
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'email_address',
        'phone_number',
        'address',
        'address_details',
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
     * Get the full name of the client.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Scope a query to only include active clients.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    /**
     * Scope a query to only include inactive clients.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Get the clients' full address.
     *
     * @return string
     */
    public function getFullAddressAttribute()
    {
        return trim("{$this->address} {$this->address_details}");
    }
    /**     * Get the clients' phone number with a formatted string.
     *
     * @return string
     */
        public function getFormattedPhoneNumberAttribute()
        {
            return $this->phone_number ? "Phone: {$this->phone_number}" : 'No phone number';
        }
    }