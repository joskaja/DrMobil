<?php

namespace App\Models;


use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'active',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get users full name (first and second name together)
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Basket of current User relationship
     * @return HasOne
     */
    public function basket(): hasOne
    {
        return $this->hasOne(Basket::class);
    }

    /**
     * Address of current User relationship
     * @return BelongsTo
     */
    public function address(): belongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Order of current User relationship
     * @return HasMany
     */
    public function orders(): hasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Send password reset e-mail when user click's on forget password link
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
