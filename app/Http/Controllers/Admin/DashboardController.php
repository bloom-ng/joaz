<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Get dashboard statistics
        $stats = [
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_customers' => User::role('customer')->count(),
            'total_revenue' => Transaction::where('status', 'successful')->sum('amount'),
            'pending_orders' => 0,
            'completed_orders' => 0,
        ];

        // Get recent orders
        $recent_orders = Order::with(['user', 'orderItems.product'])
            ->latest()
            ->take(5)
            ->get();

        // Get top selling products
        $top_products = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'top_products'));
    }
}
