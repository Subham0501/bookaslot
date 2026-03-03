<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $query = Business::where('is_active', true);

        // Filter by Category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search by Name or Product
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('business_name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhereHas('products', function($pq) use ($searchTerm) {
                      $pq->where('name', 'LIKE', '%' . $searchTerm . '%');
                  });
            });
        }

        $searchTerm = $request->search;

        if ($request->filled('search')) {
            // Define subqueries for matching price and global price
            $matchedPriceSql = '(SELECT MIN(price) FROM products WHERE products.business_id = businesses.id AND (name LIKE ? OR description LIKE ?))';
            $globalPriceSql = '(SELECT MIN(price) FROM products WHERE products.business_id = businesses.id)';
            
            // Define subquery for matched product image
            $matchedImageSql = '(SELECT image FROM products WHERE products.business_id = businesses.id AND (name LIKE ? OR description LIKE ?) AND image IS NOT NULL AND image != "" LIMIT 1)';
            
            // Define subqueries for matched product details
            $matchedNameSql = '(SELECT name FROM products WHERE products.business_id = businesses.id AND (name LIKE ? OR description LIKE ?) LIMIT 1)';
            $matchedDescSql = '(SELECT description FROM products WHERE products.business_id = businesses.id AND (name LIKE ? OR description LIKE ?) LIMIT 1)';

            $query->select('*')
                  ->selectRaw("COALESCE($matchedPriceSql, $globalPriceSql) as products_min_price", ["%$searchTerm%", "%$searchTerm%"])
                  ->selectRaw("$matchedImageSql as search_matched_image", ["%$searchTerm%", "%$searchTerm%"])
                  ->selectRaw("$matchedNameSql as search_matched_name", ["%$searchTerm%", "%$searchTerm%"])
                  ->selectRaw("$matchedDescSql as search_matched_description", ["%$searchTerm%", "%$searchTerm%"]);
        } else {
            $query->select('*')
                  ->withMin('products as products_min_price', 'price')
                  ->selectRaw('NULL as search_matched_image');
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        if ($sort == 'price_low') {
            $query->orderBy('products_min_price', 'asc');
        } elseif ($sort == 'price_high') {
            $query->orderBy('products_min_price', 'desc');
        } else {
            $query->latest();
        }

        $businesses = $query->paginate(12)->withQueryString();
        
        $categories = Business::where('is_active', true)
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->toArray();
        
        // Add default categories if empty
        if (empty($categories)) {
            $categories = ['Travel', 'Ecommerce', 'Consultancy', 'Hotel', 'Photography', 'Corporate'];
        }

        return view('marketplace', compact('businesses', 'categories'));
    }
}
