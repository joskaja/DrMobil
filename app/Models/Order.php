<?php

namespace App\Models;

use App\Events\OrderStatusChanged;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    /**
     * Order statuses codes and meanings
     * @var string[]
     */
    public $statuses = [
      0 => 'Zrušená',
      1 => 'Nově vytvořená',
      2 => 'Zabalená a odeslaná',
      3 => 'Dokončená'
    ];

    /**
     * If order status is changed fire OrderStatusChanged event
     */
    protected static function booted()
    {
        static::saved(function ($order) {
            if($order->getOriginal('status') !== $order->status) {
                event(new OrderStatusChanged($order->refresh()));
            }
        });
    }

    /**
     * Order and Address relationship
     * @return BelongsTo
     */
    public function address(): belongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Order and User relationship
     * @return BelongsTo
     */
    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order and PaymentMethod relationship
     * @return BelongsTo
     */
    public function payment_method(): belongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Order and DeliveryMethod relationship
     * @return BelongsTo
     */
    public function delivery_method(): belongsTo
    {
        return $this->belongsTo(DeliveryMethod::class);
    }

    /**
     * Order and OrderProduct relationship
     * @return HasMany
     */
    public function products(): hasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    /**
     * Get meaning of order status
     * @return string
     */
    public function getTextStatusAttribute(): string
    {
        return $this->statuses[$this->status];
    }

    /**
     * Get current Order total price including all items, delivery and payment method's prices
     * @return float
     */
    public function getTotalPriceAttribute(): float
    {
        $total_price = DB::selectOne('SELECT get_order_total_price(?) AS total_price', [$this->id]);
        return (float) $total_price->total_price;
    }
}
