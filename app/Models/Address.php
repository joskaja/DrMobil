<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Address extends Model
{
    use HasFactory;

    /**
     * Mass assignable properties
     * @var string[]
     */
    protected $fillable = [
        'street',
        'house_number',
        'city',
        'zip_code',
    ];

    /**
     * Return full address as one string
     * @return string
     */
    public function getFullAddressAttribute(): string
    {
        return "{$this->street} {$this->house_number}, {$this->city} {$this->zip_code}";
    }

    /**
     * Address and User relationship
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * Address and Order relationship
     * @return BelongsToMany
     */
    public function orders(): belongsToMany
    {
        return $this->belongsToMany(Order::class);
    }
}
