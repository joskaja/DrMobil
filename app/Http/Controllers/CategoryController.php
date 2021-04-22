<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Show the product detail by product ID.
     *
     * @param string $category category seo_url
     * @param Request $request
     * @return \Illuminate\Contracts\View\View|View
     */
    public function show(string $category, Request $request)
    {
        $sorting_methods = [
            'skladem' => ['name' => 'Skladem', 'param' => DB::raw('warehouse_amount > 0'), 'order' => 'desc', 'default' => true],
            'nejdrazsi' => ['name' => 'Nejdražší', 'param' => 'price', 'order' => 'desc'],
            'nejlevnejsi' => ['name' => 'Nejlevnější', 'param' => 'price', 'order' => 'asc'],
            'nejnovejsi' => ['name' => 'Nejnovější', 'param' => 'created_at', 'order' => 'desc']
        ];
        if (empty($request->input('seradit')) || !$sorting_method = $sorting_methods[$request->input('seradit')]) {
            $sorting_method = $sorting_methods['skladem'];
        }
        $brand = $request->input('znacka');
        $min_price = false;
        $max_price = false;
        if (!empty($request->input('cena')) && count(explode('-', $request->input('cena'))) > 1) {
            $min_price = explode('-', $request->input('cena'))[0];
            $max_price = explode('-', $request->input('cena'))[1];
        }
        $category = Category::where('url', $category)->firstOrFail();
        $products = $category->products()
            ->when($brand, function ($query, $brand) {
                return $query->whereIn('brand_id', $brand);
            })
            ->when($min_price, function ($query, $min_price) {
                return $query->where('price', '>=', $min_price);
            })
            ->when($max_price, function ($query, $max_price) {
                return $query->where('price', '<=', $max_price);
            })
            ->orderBy($sorting_method['param'], $sorting_method['order'])
            ->orderBy('created_at', 'desc')
            ->paginate(20, ['*'], 'strana')
            ->appends(request()->query());
        return view('eshop.category', [
            'category' => $category,
            'brands' => Brand::all(),
            'sorting_methods' => $sorting_methods,
            'products' => $products,
            'selected_price_from' => $min_price,
            'selected_price_to' => $max_price,
        ]);
    }

    /**
     * Show all categories in admin view
     * @return \Illuminate\Contracts\View\View|View
     */
    public function index()
    {
        return view('admin.categories', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Show add category view in admin
     * @return \Illuminate\Contracts\View\View|View
     */
    public function add()
    {
        return view('admin.category', [
            'category' => new Category,
            'action' => route('admin.categories.create')
        ]);
    }

    /**
     * Create new category
     * @param Request $request
     * @return Application|\Illuminate\Contracts\View\View|RedirectResponse|Redirector|View
     */
    public function create(Request $request)
    {
        $request->merge(['url' => Str::slug($request->name)]);
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255|unique:categories',
            'description' => 'string'
        ], [], [
            'name' => 'název kategorie',
            'url' => 'url adresa',
            'description' => 'popisek'
        ]);
        $category = new Category;
        $category_data = $request->all();
        $category_data['show_in_menu'] = $request->show_in_menu && $request->show_in_menu === 'on';
        $category->fill($category_data);
        $category->save();
        session()->flash('success_message', 'Kategorie byla úspěšně přidána.');
        return redirect(route('admin.categories'));
    }

    /**
     * Show edit form for category in admin view
     * @param int $category
     * @return \Illuminate\Contracts\View\View|View
     */
    public function edit(int $category)
    {
        $category = Category::findOrFail($category);
        return view('admin.category', [
            'category' => $category,
            'action' => route('admin.categories.update', ['category' => $category->id])
        ]);
    }

    /**
     * Update category
     * @param int $category
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(int $category, Request $request): RedirectResponse
    {
        $category = Category::findOrFail($category);
        $request->merge(['url' => Str::slug($request->name)]);
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'url')->ignore($category->id)
            ],
            'description' => 'string'
        ], [], [
            'name' => 'název kategorie',
            'url' => 'url adresa',
            'description' => 'popisek'
        ]);
        $category_data = $request->all();
        $category_data['show_in_menu'] = $category_data['show_in_menu'] && $category_data['show_in_menu'] === 'on';
        $category->fill($category_data);
        $category->save();
        session()->flash('success_message', 'Kategorie byla úspěšně upravena.');
        return redirect(route('admin.categories'));
    }

    /**
     * Delete category
     * @param int $category
     * @return RedirectResponse
     */
    public function delete(int $category): RedirectResponse
    {
        $category = Category::find($category);
        if ($category) {
            $category->delete();
            session()->flash('success_message', 'Kategorie byla úspěšně odstraněna');
        } else {
            session()->flash('error_message', 'Něco se nepovedlo');
        }
        return redirect()->back();
    }
}
