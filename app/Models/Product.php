<?php

namespace App\Models;

use App\Providers\ExactSearchServiceProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use AjCastro\Searchable\Searchable;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'url', 'short_description', 'description', 'warehouse_amount', 'price'];
    /**
     * Columns that are searchable in Product model when searching products
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'products.short_description',
            'products.description',
            'products_full_name' => 'CONCAT(categories.name, " ", brands.name, " ", products.name)',
        ],
        'joins' => [
            'brands' => ['brands.id', 'products.brand_id'],
            'categories' => ['categories.id', 'products.category_id']

        ]
    ];

    /**
     * Default search query
     * @return ExactSearchServiceProvider
     */
    public function defaultSearchQuery(): ExactSearchServiceProvider
    {
        return new ExactSearchServiceProvider($this, $this->searchableColumns(), $this->sortByRelevance, 'where');
    }

    /**
     * Full name of current product (including brand)
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->brand->name} {$this->name}";
    }

    /**
     * Brand of current Product relationship
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Category of current product relationship
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Image of current Product relationship
     * @return belongsTo
     */
    public function image(): belongsTo
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * Properties of current Product relationship
     * @return hasMany
     */
    public function properties(): hasMany
    {
        return $this->hasMany(ProductPropertyValue::class);
    }


}
