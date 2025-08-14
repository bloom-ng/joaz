<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
        $categories = Category::with('parent')->get();

        return view('customer.shop.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        if ($product->quantity <= 0) {
            abort(404);
        }

        $product->load(['category', 'images', 'variants']);

        // Get related products from same category
        $relatedProducts = Product::with(['category', 'images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->where('quantity', '>', 0)
            ->limit(4)
            ->get();

        return view('customer.shop.shop', compact('product', 'relatedProducts'));
    }

    public function productDetails($id)
    {

        $product = Product::with(['category', 'images', 'variants', 'reviews.user'])->findOrFail($id);

        // Fetch related products from the same category, excluding the current one.
        $relatedProducts = collect();
        if ($product->category_id) {
            $relatedProducts = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->with('images') // Eager load images for performance.
                ->inRandomOrder()
                ->limit(3)
                ->get();
        }

        // Fetch random product images for the review gallery section.
        $reviewImages = ProductImage::inRandomOrder()->limit(10)->get();

        return view('customer.shop.shop', compact('product', 'relatedProducts', 'reviewImages'));
    }

    public function showCategory(Category $category)
    {
        $products = $category->products()->with('images')->paginate(9);
        return view('customer.shop.category', compact('category', 'products'));
    }

    public function categoryPage(Request $request, Category $category = null)
    {
        $perPage = 9;
        $searchQuery = $request->input('search');

        // Get 4 random parent categories
        $parentCategories = Category::whereNull('parent_category_id')
            ->inRandomOrder()
            ->take(4)
            ->get();

        // If category is selected, eager load children
        $selectedCategory = $category
            ? $category->load('children')
            : $parentCategories->first();

        // Get best selling products (top 3 most ordered products)
        $bestSellers = Product::with('images')
            ->where('quantity', '>', 0)
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(3)
            ->get();

        // Prepare default collections
        $childCategories = collect();
        $products = collect();
        $relatedProducts = collect();

        if ($selectedCategory) {
            // Use already eager-loaded children
            $childCategories = $selectedCategory->children;

            // Get all category IDs in one go
            $categoryIds = $childCategories->pluck('id')->push($selectedCategory->id);

            // Build product query
            $productsQuery = Product::with('images')
                ->where('quantity', '>', 0)
                ->whereIn('category_id', $categoryIds);

            // Search filter
            if ($searchQuery) {
                $productsQuery->where(function ($query) use ($searchQuery) {
                    $query->where('name', 'like', "%{$searchQuery}%")
                          ->orWhere('description', 'like', "%{$searchQuery}%");
                });
            }

            // Paginate products
            $products = $productsQuery->paginate($perPage)
                ->appends(['search' => $searchQuery]);

            // Related products (excluding current and best sellers)
            $excludeIds = $products->pluck('id')->merge($bestSellers->pluck('id'))->unique();

            $relatedProducts = Product::with('images')
                ->whereIn('category_id', $categoryIds)
                ->where('quantity', '>', 0)
                ->whereNotIn('id', $excludeIds)
                ->inRandomOrder()
                ->limit(3)
                ->get();
        }

        return view('customer.shop.wigs', [
            'parentCategories' => $parentCategories,
            'selectedCategory' => $selectedCategory,
            'childCategories' => $childCategories,
            'products' => $products,
            'searchQuery' => $searchQuery,
            'relatedProducts' => $relatedProducts,
            'bestSellers' => $bestSellers
        ]);
    }



    public function home()
    {
        // First get the product IDs with their order counts
        $productIds = DB::table('products')
            ->select('products.id', DB::raw('COUNT(order_items.id) as order_count'))
            ->join('order_items', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('product_images', 'product_images.product_id', '=', 'products.id')
            ->where('products.quantity', '>', 0)
            ->where('orders.order_status', 'delivered')
            ->groupBy('products.id')
            ->orderBy('order_count', 'DESC')
            ->inRandomOrder()
            ->limit(3)
            ->pluck('products.id');

        // Now get the full product details for those IDs with images and category
        $mostOrderedProducts = Product::whereIn('id', $productIds)
            ->with(['category', 'images'])
            ->get()
            ->shuffle();

        // If we don't have enough ordered products, get random products within price range
        if ($mostOrderedProducts->count() < 3) {
            $needed = 3 - $mostOrderedProducts->count();
            $randomProducts = Product::where('quantity', '>', 0)
                ->whereBetween('price_ngn', [5000, 100000])
                ->whereNotIn('id', $mostOrderedProducts->pluck('id'))
                ->inRandomOrder()
                ->limit($needed)
                ->get();

            $mostOrderedProducts = $mostOrderedProducts->merge($randomProducts);
        }

        // Get 3 random products from different categories with images
        $randomCategoryProducts = Product::where('quantity', '>', 0)
            ->whereHas('category')
            ->with(['category', 'images'])
            ->inRandomOrder()
            ->get()
            ->unique('category_id')
            ->take(3);

        return view('welcome', compact('mostOrderedProducts', 'randomCategoryProducts'));
    }
}
