<?php

namespace App\Http\Middleware;

use App\Http\Controllers\BasketController;
use App\Models\Category;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class Eshop
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handle(Request $request, Closure $next)
    {
        $eshop_categories = Category::all();
        View::share('eshop_categories', $eshop_categories);
        $eshop_basket = (new BasketController)->get(false);
        View::share('eshop_basket', $eshop_basket);
        return $next($request);

    }
}
