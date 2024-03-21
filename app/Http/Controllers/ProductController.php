<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function fetch()
    {
        $products = Product::with(['offers' => function ($query) {
            $query->whereDate('start_date', '<=', now())
                  ->whereDate('end_date', '>=', now())
                  ->where('active', true) // Assuming there's a column 'active' in offers table
                  ->orderByDesc('discount') // Order by discount, assuming higher discount is preferred
                  ->limit(1); // Get only the active offer
        }])
        ->withCount(['offers'])
        ->select('products.*', DB::raw('ROUND(products.price * (1 - COALESCE((SELECT MAX(discount) FROM offer_product JOIN offers ON offer_product.offer_id = offers.id WHERE offer_product.product_id = products.id AND start_date <= CURRENT_DATE AND end_date >= CURRENT_DATE AND active = 1), 0) / 100), 2) AS discounted_price'))
        ->orderBy('discounted_price')
        ->get();

        return $products;
    }
}
