<?php


namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class SearchController
{
    /**
     * Search products and show results
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse|Redirector
     */
    public function search(Request $request) {
        if(!empty($request->input('q'))) {
            return view('eshop.search', [
                'products' => Product::search($request->input('q'))->get(),
                'query' => $request->input('q')
            ]);
        } else {
            return redirect(route('home'));
        }
    }
}
