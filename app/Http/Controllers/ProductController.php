<?php

namespace App\Http\Controllers;


use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductProperty;
use App\Models\ProductPropertyValue;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{

    /**
     * Show product detail in e-shop
     * @param string $product
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function show(string $product)
    {
        return view('eshop.product', [
            'product' => Product::where('url', $product)->firstOrFail()
        ]);

    }

    /**
     * List all products in admin view
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.products', [
            'products' => Product::orderBy('created_at', 'desc')->paginate(20, ['*'], 'strana')
        ]);
    }


    /**
     * Show add new product form in admin
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function add()
    {
        return view('admin.product', [
            'product' => new Product,
            'brands' => Brand::all()->keyBy('id')->pluck('name', 'id'),
            'categories' => Category::all()->keyBy('id')->pluck('name', 'id'),
            'product_properties' => ProductProperty::all()->keyBy('id')->pluck('name', 'id'),
            'action' => route('admin.products.create')
        ]);
    }

    /**
     * Create new product
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function create(Request $request)
    {
        $brand = new Brand();
        if (!empty($request->brand)) {
            $brand = (new BrandController())->quickCreate($request->brand);
        }
        $request->merge(['url' => Str::slug($brand->name . ' ' . $request->name)]);
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255|unique:products',
            'short_description' => 'string|max:255|required',
            'description' => 'string|required',
            'brand' => 'required',
            'category' => 'required',
            'warehouse_amount' => 'numeric',
            'price' => 'numeric|min:1|required',
            'image' => 'image|required'
        ], [], [
            'name' => 'název produktu',
            'url' => 'url adresa',
            'short_description' => 'krátký popisek',
            'description' => 'dlouhý popis',
            'brand' => 'značka',
            'category' => 'kategorie',
            'warehouse_amount' => 'množství skladem',
            'price' => 'cena',
            'image' => 'obrázek'
        ]);
        $product = new Product;
        $product->name = $request->name;
        $product->url = $request->url;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->warehouse_amount = $request->warehouse_amount;
        $product->price = $request->price;
        $category = Category::find(str_replace('category_id_', '', $request->category));
        $product->category()->associate($category);
        $product->brand()->associate($brand);
        $image = (new ImageController)->store($request->file('image'), $request->name);
        $product->image()->associate($image);
        $product->save();
        foreach (json_decode($request->product_properties_json, true) as $product_property) {
            (new ProductPropertyController())->quickCreate($product_property['key'], $product_property['value'], $product->id);
        }
        session()->flash('success_message', 'Produkt byl úspěšně přidán.');
        return redirect(route('admin.products'));
    }


    /**
     * Show edit product form
     * @param int $product
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $product)
    {
        $product = Product::findOrFail($product);
        return view('admin.product', [
            'product' => $product,
            'brands' => Brand::all()->keyBy('id')->pluck('name', 'id'),
            'categories' => Category::all()->keyBy('id')->pluck('name', 'id'),
            'product_properties' => ProductProperty::all()->keyBy('id')->pluck('name', 'id'),
            'action' => route('admin.products.update', ['product' => $product->id])
        ]);
    }

    /**
     * Update product data
     * @param int $product
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function update(int $product, Request $request)
    {
        $product = Product::findOrFail($product);
        $brand = new Brand();
        if (!empty($request->brand)) {
            $brand = (new BrandController())->quickCreate($request->brand);
        }
        $request->merge(['url' => Str::slug($brand->name . ' ' . $request->name)]);
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'url')->ignore($product->id)
            ],
            'short_description' => 'string|max:255|required',
            'description' => 'string|required',
            'brand' => 'required',
            'category' => 'required',
            'warehouse_amount' => 'numeric',
            'price' => 'numeric|min:1|required',
            'image' => 'image'
        ], [], [
            'name' => 'název produktu',
            'url' => 'url adresa',
            'short_description' => 'krátký popisek',
            'description' => 'dlouhý popis',
            'brand' => 'značka',
            'category' => 'kategorie',
            'warehouse_amount' => 'množství skladem',
            'price' => 'cena',
            'image' => 'obrázek'
        ]);
        $product->name = $request->name;
        $product->url = $request->url;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->warehouse_amount = $request->warehouse_amount;
        $product->price = $request->price;
        $category = Category::find(str_replace('category_id_', '', $request->category));
        $product->category()->associate($category);
        $product->brand()->associate($brand);
        $old_image = false;
        if ($request->hasFile('image')) {
            $old_image = $product->image();
            $image = (new ImageController)->store($request->file('image'), $request->name);
            $product->image()->associate($image);
        }
        $product->save();
        if ($old_image) $old_image->delete();
        ProductPropertyValue::where('product_id', $product->id)->delete();
        if ($request->product_properties_json) {
            foreach (json_decode($request->product_properties_json, true) as $product_property) {
                (new ProductPropertyController())->quickCreate($product_property['key'], $product_property['value'], $product->id);
            }
        }
        session()->flash('success_message', 'Produkt byl úspěšně přidán.');
        return redirect(route('admin.products'));
    }

    /**
     * Delete product
     * @param int $product
     * @return RedirectResponse
     */
    public function delete(int $product): RedirectResponse
    {
        $product = Product::find($product);
        if ($product) {
            $product->delete();
            session()->flash('success_message', 'Produkt byl úspěšně odstraněn');
        } else {
            session()->flash('error_message', 'Něco se nepovedlo');
        }
        return redirect()->back();
    }
}
