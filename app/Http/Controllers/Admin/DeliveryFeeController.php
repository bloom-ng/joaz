<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryFee;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliveryFees = DeliveryFee::latest()->paginate(10);
        return view('admin.delivery-fees.index', compact('deliveryFees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = DB::table('countries')->orderBy('name')->get();

        return view('admin.delivery-fees.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'country' => 'required|string|max:255|unique:delivery_fees,country',
            'amount' => 'required|numeric|min:0|max:999999.99',
        ]);

        DeliveryFee::create($validated);

        return redirect()->route('admin.delivery-fees.index')
            ->with('success', 'Delivery fee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DeliveryFee $deliveryFee)
    {
        return view('admin.delivery-fees.show', compact('deliveryFee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeliveryFee $deliveryFee)
    {
        $countries = Country::where(function($query) use ($deliveryFee) {
            $query->whereNotIn('name', function($q) {
                $q->select('country')->from('delivery_fees');
            })->orWhere('name', $deliveryFee->country);
        })->orderBy('name')->get();

        return view('admin.delivery-fees.edit', compact('deliveryFee', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeliveryFee $deliveryFee)
    {
        $validated = $request->validate([
            'country' => 'required|string|max:255|unique:delivery_fees,country,' . $deliveryFee->id,
            'amount' => 'required|numeric|min:0|max:999999.99',
        ]);

        $deliveryFee->update($validated);

        return redirect()->route('admin.delivery-fees.index')
            ->with('success', 'Delivery fee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryFee $deliveryFee)
    {
        $deliveryFee->delete();

        return redirect()->route('admin.delivery-fees.index')
            ->with('success', 'Delivery fee deleted successfully');
    }
}
