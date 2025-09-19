<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $query = Transaction::with(['order.user'])
            ->latest();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('transaction_reference', 'like', "%{$search}%")
                  ->orWhere('gateway', 'like', "%{$search}%")
                  ->orWhere('amount', $search)
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhereHas('order', function($q) use ($search) {
                      $q->where('id', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && in_array($request->status, ['pending', 'successful', 'failed', 'cancelled'])) {
            $query->where('status', $request->status);
        }

        $transactions = $query->paginate(15);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction): View
    {
        $transaction->load(['order.user', 'order.orderItems.product']);
        return view('admin.transactions.show', compact('transaction'));
    }




}
