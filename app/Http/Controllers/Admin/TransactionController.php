<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(): View
    {
        $transactions = Transaction::with(['order.user'])
            ->latest()
            ->paginate(15);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction): View
    {
        $transaction->load(['order.user', 'order.orderItems.product']);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction): View
    {
        $transaction->load('order');
        return view('admin.transactions.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,successful,failed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $transaction->update($validated);

        return redirect()->route('admin.transactions.show', $transaction)
            ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        // Only allow deletion of failed or cancelled transactions
        if (!in_array($transaction->status, ['failed', 'cancelled'])) {
            return redirect()->route('admin.transactions.index')
                ->with('error', 'Only failed or cancelled transactions can be deleted.');
        }

        $transaction->delete();

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }

    public function details(Transaction $transaction): View
    {
        $transaction->load(['order.user', 'order.orderItems.product', 'order.delivery']);
        return view('admin.transactions.details', compact('transaction'));
    }
}
