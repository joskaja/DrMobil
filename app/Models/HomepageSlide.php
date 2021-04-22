<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomepageSlide extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'text',
        'target_url'
    ];

    /**
     * Image of current HomepageSlide
     * @return belongsTo
     */
    public function image(): belongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
