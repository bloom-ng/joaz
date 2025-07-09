<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::with(['orders'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:20|unique:vouchers,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after:now',
            'description' => 'nullable|string|max:255',
        ]);

        // Validate percentage voucher
        if ($request->type === 'percentage' && $request->value > 100) {
            return back()->withErrors(['value' => 'Percentage discount cannot exceed 100%.']);
        }

        Voucher::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $request->min_order_amount,
            'max_uses' => $request->max_uses,
            'expires_at' => $request->expires_at,
            'description' => $request->description,
            'is_active' => true,
        ]);

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher created successfully.');
    }

    public function show(Voucher $voucher)
    {
        $voucher->load(['orders.user']);

        return view('admin.vouchers.show', compact('voucher'));
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'code' => 'required|string|max:20|unique:vouchers,code,' . $voucher->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'description' => 'nullable|string|max:255',
        ]);

        // Validate percentage voucher
        if ($request->type === 'percentage' && $request->value > 100) {
            return back()->withErrors(['value' => 'Percentage discount cannot exceed 100%.']);
        }

        $voucher->update([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $request->min_order_amount,
            'max_uses' => $request->max_uses,
            'expires_at' => $request->expires_at,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher updated successfully.');
    }

    public function destroy(Voucher $voucher)
    {
        if ($voucher->orders()->count() > 0) {
            return back()->withErrors(['voucher' => 'Cannot delete voucher that has been used.']);
        }

        $voucher->delete();

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher deleted successfully.');
    }

    public function activate(Voucher $voucher)
    {
        $voucher->update(['is_active' => true]);

        return back()->with('success', 'Voucher activated successfully.');
    }

    public function deactivate(Voucher $voucher)
    {
        $voucher->update(['is_active' => false]);

        return back()->with('success', 'Voucher deactivated successfully.');
    }

    public function generateCode()
    {
        $code = 'VOUCHER-' . strtoupper(Str::random(8));

        return response()->json(['code' => $code]);
    }
}
