<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PickupAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PickupAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pickupAddresses = PickupAddress::latest()->paginate(10);
        return view('admin.pickup-addresses.index', compact('pickupAddresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = DB::table('countries')->orderBy('name')->get();
        
        return view('admin.pickup-addresses.create', [
            'isEdit' => false,
            'pickupAddress' => new PickupAddress(),
            'countries' => $countries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        PickupAddress::create($validated);

        return redirect()->route('admin.pickup-addresses.index')
            ->with('success', 'Pickup address created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PickupAddress $pickupAddress)
    {
        return view('admin.pickup-addresses.show', compact('pickupAddress'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PickupAddress $pickupAddress)
    {
        $countries = DB::table('countries')->orderBy('name')->get();
        
        return view('admin.pickup-addresses.edit', [
            'isEdit' => true,
            'pickupAddress' => $pickupAddress,
            'countries' => $countries
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PickupAddress $pickupAddress)
    {
        $validated = $request->validate([
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        $pickupAddress->update($validated);

        return redirect()->route('admin.pickup-addresses.index')
            ->with('success', 'Pickup address updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PickupAddress $pickupAddress)
    {
        $pickupAddress->delete();

        return redirect()->route('admin.pickup-addresses.index')
            ->with('success', 'Pickup address deleted successfully');
    }

    /**
     * Toggle the active status of the pickup address.
     */
}
