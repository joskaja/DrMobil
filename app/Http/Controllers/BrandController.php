<?php


namespace App\Http\Controllers;


use App\Models\Brand;
use App\Traits\DialsControllerFunctions;

class BrandController extends Controller
{
    use DialsControllerFunctions;

    /**
     * Model of current Dial controller
     * @var string
     */
    protected $model = Brand::class;
    /**
     * Route of current dial controller
     * @var string
     */
    protected $route = 'admin.dials.brands';
    /**
     * Title of current Dial
     * @var string
     */
    protected $name = 'značky';

    /**
     * Create or return brand from select input
     * @param string $brand_key
     * @return mixed
     */
    public function quickCreate(string $brand_key) {
        if(str_starts_with($brand_key, 'new_tag_')){
            $brand = Brand::create([
                'name' =>  str_replace('new_tag_', '', $brand_key)
            ]);
        } else {
            $brand = Brand::find(str_replace('brand_id_', '', $brand_key));
        }
        return $brand;
    }
}
