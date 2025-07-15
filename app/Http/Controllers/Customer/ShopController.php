<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images'])
            ->where('quantity', '>', 0);

        // Filter by category (include descendants)
        if ($request->has('category') && $request->category) {
            $category = Category::find($request->category);
            if ($category) {
                // Get all descendant IDs recursively
                $categoryIds = collect([$category->id]);
                $fetchDescendants = function ($cat) use (&$categoryIds, &$fetchDescendants) {
                    foreach ($cat->children as $child) {
                        $categoryIds->push($child->id);
                        $fetchDescendants($child);
                    }
                };
                $category->load('children');
                $fetchDescendants($category);
                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Search by name or description
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Sort products
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('customer.shop.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        if ($product->quantity <= 0) {
            abort(404);
        }

        $product->load(['category', 'images']);

        // Get related products from same category
        $relatedProducts = Product::with(['category', 'images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->where('quantity', '>', 0)
            ->limit(4)
            ->get();

        return view('customer.shop.show', compact('product', 'relatedProducts'));
    }
}
