<?php


namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    /**
     * Show admin dashboard with stats
     * @return Application|Factory|View
     */
    public function index()
    {
        $income_by_period_db = DB::select('CALL income_by_period("%v-%Y")');
        $income_by_period = array();
        foreach ($income_by_period_db as $income) {
            $income_by_period[] = ['name' => $income->period, 'y' => (float)$income->amount];
        }
        return view('admin.dashboard', [
                'products_sales' => DB::select('SELECT * FROM products_sales ORDER BY amount DESC LIMIT 5'),
                'categories_shares' => DB::select('SELECT category as name, CAST(amount AS SIGNED) as y FROM categories_shares'),
                'income_by_period' => $income_by_period,
            ]
        );
    }
}
