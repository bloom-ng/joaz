<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|string|in:male,female',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Update user phone
            if ($request->has('phone')) {
                $user->phone = $request->phone;
                $user->save();
            }

            // Update or create profile with gender
            if ($request->has('gender')) {
                $profile = $user->profile()->firstOrNew();
                $profile->gender = $request->gender;
                $profile->save();
            }

            // Commit the transaction
            DB::commit();

            return back()->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            // Rollback the transaction on error
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            return back()->with('error', 'Failed to update profile');
        }
    }


    public function updateAddress(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:20',
            'address' =>'required|string',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'is_default' => 'sometimes|boolean',
            'address_id' => 'nullable|exists:addresses,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            DB::beginTransaction();

            $addressData = [
                'label' => $request->label,
                'address' => $request->address,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'is_default' => $request->boolean('is_default', false),
            ];

            // If setting as default, unset default from other addresses
            if ($addressData['is_default']) {
                $user->addresses()->where('is_default', true)->update(['is_default' => false]);
            }

            if ($request->filled('address_id')) {
                // Update existing address
                $address = $user->addresses()->findOrFail($request->address_id);
                $address->update($addressData);
            } else {
                // Create new address
                $address = $user->addresses()->create($addressData);
            }

            DB::commit();

            return back()->with('success', 'Address saved successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to save address: ' . $e->getMessage());
        }
    }

}
