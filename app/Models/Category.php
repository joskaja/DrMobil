<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    /**
     * Model doesn't have timestamps
     * @var bool
     */
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'url',
        'description',
        'show_in_menu',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'show_in_menu' => 'boolean',
    ];
    /**
     * Products of category relationship
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get min and max price of products in current category
     * @return array
     */
    public function getMinMaxPriceAttribute(): array
    {
        $minmax_price = DB::selectOne('CALL get_minmax_price_by_category(?)', [$this->id]);
        return (array) $minmax_price;
    }
}
