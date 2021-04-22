<?php


namespace App\Http\Controllers;


use App\Models\ProductProperty;
use App\Models\ProductPropertyValue;
use App\Traits\DialsControllerFunctions;

class ProductPropertyController extends Controller
{
    use DialsControllerFunctions;

    /**
     * @var ProductProperty
     */
    protected $model = ProductProperty::class;
    /**
     * Current Dial view
     * @var string
     */
    protected $route = 'admin.dials.product_properties';
    /**
     * Dial title
     * @var string
     */
    protected $name = 'vlastnosti produktů';

    /**
     * Quick create or return product property
     * @param string $property_key
     * @param string $value
     * @param int $product_id
     * @return mixed
     */
    public function quickCreate(string $property_key, string $value, int $product_id)
    {
        if (str_starts_with($property_key, 'new_tag_')) {
            $property = ProductProperty::create([
                'name' => str_replace('new_tag_', '', $property_key)
            ]);
        } else {
            $property = ProductProperty::find(str_replace('product_properties_id_', '', $property_key));
        }
        $property->values()->save(ProductPropertyValue::create([
            'value' => $value,
            'product_property_id' => $property->id,
            'product_id' => $product_id
        ]));
        return $property;
    }
}
