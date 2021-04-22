<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductPropertyValue extends Model
{
    use HasFactory;
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string[]
     */
    protected $fillable = ['value', 'product_property_id', 'product_id'];

    /**
     * Property of current ProductPropertyValue relationship
     * @return BelongsTo
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(ProductProperty::class, 'product_property_id', 'id');
    }
    /**
     * Products of current product property value relationship
     * @return belongsTo
     */
    public function product(): belongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
