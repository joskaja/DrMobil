<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BasketItem extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount'
    ];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * BasketItem and Product relationship
     * @return BelongsTo
     */
    public function product(): belongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * BasketItem and Basket relationship
     * @return BelongsTo
     */
    public function basket(): belongsTo
    {
        return $this->belongsTo(Basket::class);
    }
}
