<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'order_id',
        'amount',
        'price',
    ];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Order and OrderProduct relationship
     * @return BelongsTo
     */
    public function order(): belongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Product and OrderProduct relationship
     * @return BelongsTo
     */
    public function product(): belongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
