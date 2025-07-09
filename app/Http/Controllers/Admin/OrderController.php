<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with(['user', 'orderItems.product'])
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'orderItems.product', 'delivery', 'transaction']);
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order): View
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'notes' => 'nullable|string',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        // Only allow deletion of cancelled orders
        if ($order->status !== 'cancelled') {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Only cancelled orders can be deleted.');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update($validated);

        return redirect()->back()
            ->with('success', 'Order status updated successfully.');
    }

    public function invoice(Order $order): Response
    {
        $order->load(['user', 'orderItems.product']);

        // Generate PDF invoice (you can use a package like DomPDF)
        // For now, we'll return a view
        return response()->view('admin.orders.invoice', compact('order'))
            ->header('Content-Type', 'application/pdf');
    }
}
