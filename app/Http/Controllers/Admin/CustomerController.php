<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = User::role('customer')
            ->withCount('orders')
            ->latest()
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer): View
    {
        $customer->load(['orders' => function ($query) {
            $query->latest()->paginate(10);
        }, 'profile']);

        return view('admin.customers.show', compact('customer'));
    }

    public function edit(User $customer): View
    {
        $customer->load('profile');
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $customer->update($validated);

        // Update profile if exists
        if ($customer->profile) {
            $customer->profile->update([
                'phone' => $validated['phone'] ?? $customer->profile->phone,
            ]);
        }

        return redirect()->route('admin.customers.show', $customer)
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(User $customer): RedirectResponse
    {
        // Check if customer has orders
        if ($customer->orders()->count() > 0) {
            return redirect()->route('admin.customers.index')
                ->with('error', 'Cannot delete customer with existing orders.');
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }

    public function orders(User $customer): View
    {
        $orders = $customer->orders()
            ->with(['orderItems.product'])
            ->latest()
            ->paginate(15);

        return view('admin.customers.orders', compact('customer', 'orders'));
    }
}
