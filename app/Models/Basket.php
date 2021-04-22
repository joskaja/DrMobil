<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Basket extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'session_id'
    ];
    /**
     * Keys of basket form inputs
     * @var string[]
     */
    public $form_data_keys = [
        'email',
        'first_name',
        'last_name',
        'street',
        'house_number',
        'city',
        'zip_code'
    ];

    /**
     * Basket and User relationship
     * @return BelongsTo
     */
    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Items of current basket relationship
     * @return HasMany
     */
    public function items(): hasMany
    {
        return $this->hasMany(BasketItem::class);
    }

    /**
     * Get total price of items in basket
     * @return float
     */
    public function getTotalPriceAttribute(): float
    {
        $total_price = DB::selectOne('SELECT get_basket_total_price(?) AS total_price', [$this->id]);
        return (float) $total_price->total_price;
    }
}
