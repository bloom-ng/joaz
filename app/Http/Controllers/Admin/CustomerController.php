<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::role('customer')->withCount('orders');

        // Handle search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $customers = $query->latest()->paginate(15);
        
        // Preserve search parameters in pagination links
        $customers->appends($request->query());

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
            // Profile fields
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'bio' => 'nullable|string',
            'social_links' => 'nullable|string', // will be parsed to array
        ]);

        $customer->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? $customer->phone,
        ]);

        // Handle avatar upload
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        // Prepare profile data
        $profileData = [
            'gender' => $validated['gender'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'social_links' => isset($validated['social_links']) ? array_filter(array_map('trim', explode(',', $validated['social_links']))) : null,
        ];
        if ($avatarPath) {
            $profileData['avatar'] = $avatarPath;
        }

        // Update or create profile
        if ($customer->profile) {
            $customer->profile->update($profileData);
        } else {
            $customer->profile()->create($profileData);
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
